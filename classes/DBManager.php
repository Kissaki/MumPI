<?php
require_once(MUMPHPI_MAINDIR . '/classes/SettingsManager.php');
require_once(MUMPHPI_MAINDIR . '/classes/MessageManager.php');
require_once(MUMPHPI_MAINDIR . '/classes/TranslationManager.php');

/**
 * Provides database functionality for the interface
 */
class DBManager
{
	private static $instance;
	/**
	 * @return DBManager_filesystem
	 */
	public static function getInstance()
	{
		if (!isset(self::$instance) || self::$instance == null) {
			$dbType = SettingsManager::getInstance()->getDBType();
			if (class_exists('DBManager_'.$dbType)) {
				eval('self::$instance = new DBManager_'.$dbType.'();');
			} else {
				MessageManager::addError(tr('error_db_unknowntype'));
			}
		}
		return self::$instance;
	}

	/**
	 * default adminGroupPerms array structure with default values (no perms)
	 * @var array
	 */
	public static $defaultAdminGroupPerms = array('groupID'=>null, 'serverID'=>null, 'startStop'=>false, 'editConf'=>false, 'genSuUsPW'=>false, 'viewRegistrations'=>false, 'editRegistrations'=>false, 'moderate'=>false, 'kick'=>false, 'ban'=>false, 'channels'=>false, 'acls'=>false, 'admins'=>false);
//	public static $defaultAdminGroupPerms = new Server_Admin_Group_Permissions(false, false, false, false, false, false, false, false, false, false, false);
}

/**
 * Database functionality for the interface
 * using the filesystem for persistend storage
 */
class DBManager_filesystem
{
	private static $filename_admins									= 'admins.dat';
	private static $filename_adminGroups						= 'admin_groups.dat';
	private static $filename_adminGroupPermissions	= 'admin_group_permissions.dat';
	private static $filename_adminGroupAssoc				= 'admin_group_assoc.dat';
	private static $filename_adminGroupServerAssoc	= 'admin_group_server_assoc.dat';

	private $filepath_admins;
	private $filepath_awaiting;
	private $filepath_log_register;
	private $filepath_adminGroups;
	private $filepath_adminGroupPermissions;
	private $filepath_adminGroupAssoc;
	private $filepath_adminGroupServerAssoc;


	/**
	 * constructor of DBManager filesystem
	 * @return DBManager_filesystem
	 */
	function __construct()
	{
		$datapath = SettingsManager::getInstance()->getMainDir() . '/data/';
		$this->filepath_admins					= $datapath . self::$filename_admins;
		$this->filepath_awaiting				= $datapath . 'awaiting.dat';
		$this->filepath_log_register			= $datapath . 'log_register.log';
		$this->filepath_adminGroups				= $datapath . self::$filename_adminGroups;
		$this->filepath_adminGroupPermissions	= $datapath . self::$filename_adminGroupPermissions;
		$this->filepath_adminGroupAssoc			= $datapath . self::$filename_adminGroupAssoc;
		$this->filepath_adminGroupServerAssoc	= $datapath . self::$filename_adminGroupServerAssoc;

		// if data dir does not exist yet, redirect to installer
		if (
			!is_writable(SettingsManager::getInstance()->getMainDir() . '/data')
			|| !is_writable(SettingsManager::getInstance()->getMainDir() . '/data/admins.dat')
			) {
			header('Location: ../install/');
		}

	}

	/**
	 * Write a message to a specific file.
	 * @param $filename
	 * @param $msg
	 */
	public function append($field, $msg)
	{
		$fd = fopen(SettingsManager::getInstance()->getMainDir().'/data/'.$field, 'a') OR die('could not open DB file');
		fwrite($fd, $msg."\n");
		fclose($fd);
	}

	/**************************************************************************
	 *** Admin Account Activation ***
	 *************************************************************************/
	/**
	 * Add an account awaiting activation/authentification.
	 * @param $sid	ServerID
	 * @param $name	account name
	 * @param $pw	password
	 * @param $email email address
	 */
	public function addAwaitingAccount($sid, $name, $pw, $email)
	{
		$fd = fopen(SettingsManager::getInstance()->getMainDir().'/data/awaiting.dat', 'a') OR die('could not open DB file');

		// Make sure the activation code is explicit
		do {
			$key = (string)md5(rand());
		} while ( $this->getAwaitingAccount($key)!=null );

		// TODO: is this even allowed? ";" in name?
		$name = str_replace(';', '/;/', $name);
		// TODO: pw should be saved as hash here as well
		$pw = str_replace(';', '/;/', $pw);
		$line = $key.';;;'.$sid.';;;'.$name.';;;'.$pw.';;;'.$email."\n";
		fwrite($fd, $line);
		fclose($fd);

		// send mail
		$this->sendActivationMail($email, $name, $sid, $key);
	}
	/**
	 * send an email with the account activation key
	 * @param $email email address
	 * @param $name account name
	 * @param $sid server ID
	 * @param $key activation key
	 */
	public function sendActivationMail($email, $name, $sid, $key)
	{
		mail(
			$email,											// to
			tr('register_mail_auth_subj'),						// subject
			sprintf( tr('register_mail_auth_body'),				// body...
				SettingsManager::getInstance()->getSiteTitle(),
				HelperFunctions::getBaseURL(),
				SettingsManager::getInstance()->getServerName($sid),
				HelperFunctions::getBaseURL(),
				$key
				),												// ...body
			'Content-Type: text/plain; charset="UTF-8"'			// +header
			);
	}

	/**
	 * Try to activate an account with the given activation key
	 * @param $key
	 */
	function activateAccount($key)
	{
		$acc = $this->getAwaitingAccount($key);
		if ($acc!=null) {
			try {
				ServerInterface::getInstance()->addUser($acc['sid'], $acc['name'], $acc['pw'], $acc['email']);
				$this->removeAwaitingAccount($key);
			} catch(Exception $exc) {

			}
		} else {
			echo '<div class="error">unknown activation key</div>';
		}
	}
	/**
	 * get account information by activation key
	 * @param $key activation key (string)
	 * @return array account information array (indices: key, sid, name, pw, email)
	 */
	function getAwaitingAccount($key)
	{
		$fd = fopen(SettingsManager::getInstance()->getMainDir().'/data/awaiting.dat', 'r') OR die('could not open DB file');
		while ($line = fgets($fd)) {
			if (substr($line, 0, 32)==$key) {
				$line = explode(';;;', $line);
				foreach ($line as $key=>$val) {
					$line[$key] = str_replace('/;/', ';', $val);
				}

				$acc = array();
				$acc['key']   = $line[0];
				$acc['sid']   = $line[1];
				$acc['name']  = $line[2];
				$acc['pw']	  = $line[3];
				$acc['email'] = str_replace("\n", '', $line[4]);

				fclose($fd);
				return $acc;
			}
		}
		fclose($fd);
		return null;
	}
	/**
	 * remove an account awaiting activation by its activation key
	 * @param unknown_type $key
	 */
	public function removeAwaitingAccount($key)
	{
		$filename = SettingsManager::getInstance()->getMainDir().'/data/awaiting.dat';
		$file = file_get_contents($filename);
		$file = preg_replace('/'.$key.';;;(.+)\n/', '', $file);
		file_put_contents($filename, $file);
	}

	/**************************************************************************
	 *** Admin Accounts ***
	 *************************************************************************/
	/**
	 * Does at least one admin account exist?
	 * @return boolean
	 */
	public function doesAdminExist()
	{
		return filesize($this->filepath_admins) > 0;
	}

	/**
	 * add an admin account
	 * @param unknown_type $username account name
	 * @param unknown_type $password password
	 * @param bool $isGlobalAdmin is the admin a global admin, with all privileges/permissions
	 */
	public function addAdmin($username, $password, $isGlobalAdmin='false')
	{
		if ($this->getAdminByName($username) == null) {
			$fd = fopen(SettingsManager::getInstance()->getMainDir().'/data/'.self::$filename_admins, 'a');
			fwrite($fd, sprintf("%s;%s;%s;%d\n", $this->getNextAdminID(), $username, sha1($password), ($isGlobalAdmin == 'true' ? 1 : 0)));
			fclose($fd);
		} else {
			MessageManager::addError(tr('error_AdminAccountAlreadyExists'));
		}
	}

	/**
	 * add an admin group
	 * @param $name group name
	 */
	public function addAdminGroup($name)
	{
		if ($this->getAdminGroupByName($name)===null) {
			$fd = fopen(SettingsManager::getInstance()->getMainDir().'/data/'.self::$filename_adminGroups, 'a');
			fwrite($fd, sprintf("%d;%s\n", $this->getNextAdminGroupID(), $name));
			fclose($fd);
		} else {
			MessageManager::addError(tr('db_admingroup_namealreadyexists'));
		}
	}

	/**
	 * @param $aid admin ID
	 * @param $gid group id
	 */
	public function addAdminToGroup($aid, $gid)
	{
		// check that admin is not already member of that group
		$groups = $this->getAdminGroupsByAdminID($aid);
		foreach ($groups AS $group) {
			if ($group['id'] == $gid) {
				MessageManager::addError(tr('db_error_admingroupassoc_alreadyexists'));
				return ;
			}
		}

		// add admin
		$fh = fopen($this->filepath_adminGroupAssoc, 'a');
		fwrite($fh, sprintf("%d;%d\n", $aid, $gid));
		fclose($fh);
	}

	/**
	 * Remove an admin account
	 * @param $aid admin account ID
	 */
	public function removeAdmin($aid)
	{
		// for database consistency, also remove admins group associations
		$this->removeAdminFromGroup($aid, null);

		$data = file($this->filepath_admins);
		$fd = fopen($this->filepath_admins, 'w');
		$size = count($data);

		for ($line = 0; $line < $size; $line++) {
			$array = explode(';', $data[$line]);
			if ($array[0] != $aid) {
				fputs($fd, $data[$line]);
			}
		}
		fclose($fd);
	}
	/**
	 * obsolete
	 * TODO: code: (obsolete) change calls to removeAdmin(…)
	 * @param $aid admin account ID
	 */
	public function removeAdminLogin($aid)
	{
		$this->removeAdmin($aid);
	}


	/**
	 * Get admin accounts
	 * @return array of admins, with id, name, pw
	 */
	public function getAdmins()
	{
		$fh = fopen($this->filepath_admins, 'r') OR MessageManager::addError('could not open '.self::$filename_admins.' file');
		$admins = array();
		while ($line = fgets($fh)) {
			$admins[] = $this->createAdminFromString($line);
		}
		fclose($fh);
		return $admins;
	}

	/**
	 * Get admin object by (account-)name.
	 * @param $username account name
	 * @return array admin object or null
	 */
	public function getAdminByName($username)
	{
		if (file_exists($this->filepath_admins)) {
			$fd = fopen($this->filepath_admins, 'r') OR MessageManager::addError('could not open '.self::$filename_admins.' file');
			while ($line = fgets($fd)) {
				$admin = $this->createAdminFromString($line);
				if ($admin['name'] == $username) {
					fclose($fd);
					return $admin;
				}
			}
		}
		return null;
	}

	/**
	 * Get an admin object by ID
	 * @param $aid admin ID
	 * @return array admin object or null if not found
	 */
	public function getAdmin($aid)
	{
		$fh = fopen($this->filepath_admins, 'r');
		$admin = null;
		$line = null;
		while ($line = fgets($fh)) {
			$admin = $this->createAdminFromString($line);
			if ($admin['id'] == $aid) {
				fclose($fh);
				return $admin;
			}
		}
		fclose($fh);
		return null;
	}
	/**
	 * Get the next free ID for an admin
	 * @return int
	 */
	private function getNextAdminID() {
		$admins = $this->getAdmins();
		// Get the maximum ID in use
		$maxid = 0;
		foreach ($admins AS $admin) {
			$maxid < $admin['id'] ? $maxid = $admin['id'] : void ;
		}
		// The next free ID is the maximum one +1
		return $maxid+1;
	}

	/**
	 * check login
	 * @param $username
	 * @param $password plain or sha1-hashed password
	 * @return bool login details correct?
	 */
	public function checkAdminLogin($username, $password){
		$admin = $this->getAdminByName($username);
		// correct login?
		if ($admin != null && ( $admin['pw'] == sha1($password))) {
			return true;
		}
		// no admins yet? create this login as admin
		if (!$this->doesAdminExist()) {
			$this->addAdmin($username, $password, true);
			return true;
		}
		// login failed
		return false;
	}

	/**
	 * Create an admin object from a db-line
	 * @param $line string with admin account data
	 * @return array admin object
	 */
	private function createAdminFromString($line)
	{
		$array = explode(';', $line);

		// remove newline character from last value
		$lastindex = count($array)-1;
		$array[$lastindex] = HelperFunctions::stripNewline($array[$lastindex]);

		$admin = array();
		$admin['id'] = $array[0];
		$admin['name'] = $array[1];
		$admin['pw'] = $array[2];
		$admin['isGlobalAdmin'] = ($array[3] == 1 ? true : false);
		return $admin;
	}

	/**************************************************************************
	 *** Admin Groups ***
	 *************************************************************************/

	/**
	 * Get the next free ID for an admin group
	 * @return int
	 */
	private function getNextAdminGroupID()
	{
		$adminGroups = $this->getAdminGroupHeads();
		// Get the maximum ID in use
		$maxid = 0;
		foreach ($adminGroups AS $ag) {
			$maxid < $ag['id'] ? $maxid = $ag['id'] : void ;
		}
		// The next free ID is the current maximum one +1
		return $maxid+1;
	}

	/**
	 * Remove an adminGroup
	 * @param $id admingroup ID
	 */
	public function removeAdminGroup($gid)
	{
		// first, make sure integrity is kept by removing obsolete assoc data
		$this->removeAdminFromGroup(null, $gid);
		$this->removeAdminGroupPermissions($gid);

		$data = file($this->filepath_adminGroups);
		$fd = fopen($this->filepath_adminGroups, 'w');
		$size = count($data);

		for ($line = 0; $line < $size; $line++) {
			$g = $this->createAdminGroupFromString($data[$line]);
			if ($g['id'] != $gid) {
				fputs($fd, $data[$line]);
			}
		}
		fclose($fd);
	}

	/**
	 * Remove an admin from an admin group or
	 * remove all admin or all group associations.
	 *
	 * If both $aid and $gid are null, it will have no effect.
	 *
	 * @param $aid admin ID or null for all
	 * @param $gid group ID or null for all
	 */
	public function removeAdminFromGroup($aid, $gid=null)
	{
		$data = file($this->filepath_adminGroupAssoc);
		$fh = fopen($this->filepath_adminGroupAssoc, 'w');
		$lines = count($data);

		for ($line = 0; $line < $lines; $line++) {
			$assoc = $this->createAdminGroupAssocFromString($data[$line]);
			if ($aid == null) {
				// remove all assocs of group
				if ($assoc['adminGroupID'] != $gid) {
					fputs($fh, $data[$line]);
				}
			}elseif ($gid == null) {
				// remove all assocs of admin
				if ($assoc['adminID'] != $aid)
					fputs($fh, $data[$line]);
			}elseif ($aid != $assoc['adminID'] || $gid != $assoc['adminGroupID']) {
				// add all others than not the one to remove
				fputs($fh, $data[$line]);
			}
		}
		fclose($fh);
	}


	/**
	 * Create an adminGroup object/array from a db-file line.
	 * @param $line line from db file
	 * @return array adminGroup object/array
	 */
	private function createAdminGroupAssocFromString($line)
	{
		$array = explode(';', $line);

		// remove newline character from last value
		$lastindex = count($array)-1;
		$array[$lastindex] = HelperFunctions::stripNewline($array[$lastindex]);

		$assoc = array();
		$assoc['adminID'] = $array[0];
		$assoc['adminGroupID'] = $array[1];
		return $assoc;
	}

	/**
	 * Get all admin groups
	 * @return array array of adminGroups
	 */
	public function getAdminGroups()
	{
		$fh = fopen($this->filepath_adminGroups, 'r');
		$groups = array();
		while ($line = fgets($fh)) {
			$groups[] = $this->createAdminGroupFromString($line);
		}
		fclose($fh);
		return $groups;
	}

	/**
	 * Get adminGroup by ID
	 * @param $gid ID
	 * @return array adminGroup array/object
	 */
	public function getAdminGroup($gid)
	{
		$fh = fopen($this->filepath_adminGroups, 'r');
		$groups=array();
		while ($line = fgets($fh)) {
			$group = $this->createAdminGroupFromString($line);
			if ($group['id'] == $gid) {
				fclose($fh);
				return $group;
			}
		}
		fclose($fh);
		return $groups;
	}

/**
	 * Get adminGroup by name
	 * @param $name name
	 * @return array adminGroup array/object
	 */
	public function getAdminGroupByName($name)
	{
		$fh = fopen($this->filepath_adminGroups, 'r');
		while ($line = fgets($fh)) {
			$group = $this->createAdminGroupFromString($line);
			if ($group['name'] == $name) {
				fclose($fh);
				return $group;
			}
		}
		fclose($fh);
		return null;
	}

	/**
	 * Get admin groups an admin is associated to by the admins ID
	 * @param $id admin ID
	 * @return array array of adminGroups, empty array if none
	 */
	public function getAdminGroupsByAdminID($aid)
	{
		$fh = fopen($this->filepath_adminGroupAssoc, 'r');
		$groups = array();
		while ($line = fgets($fh)) {
			$assoc = $this->createAdminGroupAssocFromString($line);
			if ($assoc['adminID'] == $aid) {
				$groups[] = $this->getAdminGroup($assoc['adminGroupID']);
			}
		}
		fclose($fh);

		return $groups;
	}

	public function getAdminGroupHeads()
	{
		$fh = fopen($this->filepath_adminGroups, 'r');
		$groups = array();

		while ($line = fgets($fh)) {
			$groups[] = $this->createAdminGroupHeadFromString($line);
		}

		fclose($fh);
		return $groups;
	}

	private function createAdminGroupFromString($line)
	{
		$group = $this->createAdminGroupHeadFromString($line);
		$group = $this->createAdminGroupFromAdminGroupHead($group);
		return $group;
	}

	private function createAdminGroupHeadFromString($line)
	{
		$array = explode(';', $line);

		// remove newline character from last value
		$lastindex = count($array)-1;
		$array[$lastindex] = HelperFunctions::stripNewline($array[$lastindex]);

		$group = array();
		$group['id'] = $array[0];
		$group['name'] = $array[1];
		return $group;
	}

	private function createAdminGroupFromAdminGroupHead($group)
	{
		$perms = $this->getAdminGroupPermissions($group['id']);
		$group['perms'] = $perms;
		$group['adminOnServers'] = $this->getAdminGroupServers($group['id']);
		return $group;
	}

	/**************************************************************************
	 *** Admin Group Permissions ***
	 *************************************************************************/

	/**
	 * create an array of permissions from a database-line/-row
	 * @param string $line
	 * @return array array of permissions (index: group ID => array with indices: startStop, editConf, genSuUsPW, viewRegistrations, editRegistrations, moderate, kick, ban)
	 */
	private function createAdminGroupPermissionsFromString($line)
	{
		$array = explode(';', $line);

		// remove newline character from last value
		$lastindex = count($array)-1;
		$array[$lastindex] = HelperFunctions::stripNewline($array[$lastindex]);

		$perms = array();
		$perms['groupID']   = $array[0];
		$perms['serverID']  = $array[1];
		$perms['startStop'] = (bool)$array[2];
		$perms['editConf']  = (bool)$array[3];
		$perms['genSuUsPW'] = (bool)$array[4];
		$perms['viewRegistrations'] = (bool)$array[5];
		$perms['editRegistrations'] = (bool)$array[6];
		$perms['moderate']  = (bool)$array[7];
		$perms['kick']      = (bool)$array[8];
		$perms['ban']       = (bool)$array[9];
		$perms['channels']  = (bool)$array[10];
		$perms['acls']      = (bool)$array[11];
		$perms['admins']    = (bool)$array[12];

		return $perms;
	}

	/**
	 * get permissions for a specific group
	 * @param $gid admin group ID
	 * @return object admin group permissions
	 */
	public function getAdminGroupPermissions($gid, $serverID=0)
	{
		$fh = fopen($this->filepath_adminGroupPermissions, 'r');

		$fallBack = null;
		// go through file, line by line, until EOF
		while (false !== ($line = fgets($fh))) {
			$tmpPerms = $this->createAdminGroupPermissionsFromString($line);
			if ($tmpPerms['groupID'] == $gid) {
				if ($serverID == $tmpPerms['serverID']) {
					fclose($fh);
					return $tmpPerms;

				} elseif ($tmpPerms['serverID'] == 0) {
					// fallback to global groups (groups for all servers
					if ($fallBack == null) {
						$fallBack = $tmpPerms;
					} else {
						foreach ($tmpPerms as $perm=>$value)
						{
							if (!$fallBack[$perm])
								$fallBack[$perm] = $value;
						}
					}
				}
			}
		}
		fclose($fh);

		if ($fallBack != null)
			return $fallBack;

		// no such permissions, try to get and return global ones for this group
		if ($serverID != null) {
			return $this->getAdminGroupPermissions($gid, null);
		}

		// no global perms, return default perms
		$defPerms = DBManager::$defaultAdminGroupPerms;
		$defPerms['groupID'] = $gid;
		return $defPerms;
	}

	/**
	 * add permissions for admin group
	 * @param int $gid group ID
	 * @param array $perms array of permissions (indices: startStop, editConf, genSuUsPW, viewRegistrations, editRegistrations, moderate, kick, ban)
	 */
	public function addAdminGroupPermissions($gid=null, $perms, $serverID=null)
	{
		$perms = array_merge(DBManager::$defaultAdminGroupPerms, $perms);

		if (!$perms['groupID'] || $gid != null && $perms['groupID'] != $gid) {
			$perms['groupID'] = $gid;
		}

		$this->removeAdminGroupPermissions($perms['groupID']);

		$fh = fopen($this->filepath_adminGroupPermissions, 'a');
		fwrite(
				$fh,
				sprintf("%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s;%s\n",
					$perms['groupID'], is_int($serverID)?$serverID:'0',
					$perms['startStop']?1:0, $perms['editConf']?1:0, $perms['genSuUsPW']?1:0, $perms['viewRegistrations']?1:0,
					$perms['editRegistrations']?1:0, $perms['moderate']?1:0, $perms['kick']?1:0, $perms['ban']?1:0,
					$perms['channels']?1:0, $perms['acls']?1:0, $perms['admins']?1:0
				)
			);
		fclose($fh);
	}

	/**
	 * remove group permissions for group
	 * @param unknown_type $gid group ID
	 */
	public function removeAdminGroupPermissions($groupID, $serverID=0)
	{
		$data = file($this->filepath_adminGroupPermissions);
		$fd = fopen($this->filepath_adminGroupPermissions, 'w');
		$size = count($data);

		for ($line = 0; $line < $size; $line++) {
			$perms = $this->createAdminGroupPermissionsFromString($data[$line]);
			if ($perms['groupID'] != $groupID) {
				fputs($fd, $data[$line]);
			} elseif ($serverID != $perms['serverID']) {
				fputs($fd, $data[$line]);
			}
		}
		fclose($fd);
	}

	/**
	 * @param int $adminId admin ID
	 * @return array permissions
	 */
	public function getAdminGroupPermissionsByAdminID($adminId, $serverID=null)
	{
		$groups = $this->getAdminGroupsByAdminID($adminId);
		$perms = DBManager::$defaultAdminGroupPerms;
		foreach ($groups AS $group) {
			$tmpPerms = $this->getAdminGroupPermissions($group['id'], $serverID);
			foreach ($perms AS $key=>$val) {
				if (!$val) {
					$perms[$key] = $tmpPerms[$key];
				}
			}
		}
		return $perms;
	}

	/**
	 * update a single permission
	 * @param $gid group id
	 * @param $perm permission key/name
	 * @param $newval new value
	 */
	public function updateAdminGroupPermission($gid, $perm, $newval)
	{
		$old=$this->getAdminGroupPermissions($gid);
		if (isset($old[$perm])) {
			$old[$perm] = $newval;
		}

		if (!isset($old['groupID']) || ($old['groupID'] != $gid && $gid != null)) {
			$old['groupID'] = $gid;
		}
		$this->removeAdminGroupPermissions($gid);
		$this->addAdminGroupPermissions($gid, $old);
	}
	/**
	 * set permissions for admin group
	 * @param int $gid group ID
	 * @param array $perms array of permissions (indices: startStop, editConf, genSuUsPW, viewRegistrations, editRegistrations, moderate, kick, ban)
	 */
	public function updateAdminGroupPermissions($gid, $perms)
	{
		$old=$this->getAdminGroupPermissions($gid);

		foreach ($old AS $key=>$val) {
			$old[$key] = $perms[$key];
		}

		if (!$old['groupID'] || $old['groupID'] != $gid && $gid != null) {
			$old['groupID'] = $gid;
		}
		$this->removeAdminGroupPermissions($gid);
		$this->addAdminGroupPermissions($gid, $old);
	}

	/**
	 * @param int $adminGroupID
	 * @param int $serverID
	 * @return void
	 */
	public function makeAdminGroupAdminOfServer($adminGroupID, $serverID)
	{
		// skip if the server is alredy associated to the admin group
		$groupServers = $this->getAdminGroupServers($adminGroupID);
		if (in_array($serverID, $groupServers)) {
			return;
		}

		// add assoc
		$fh = fopen($this->filepath_adminGroupServerAssoc, 'a');
		fwrite($fh, sprintf("%d;%d\n", $adminGroupID, $serverID));
		fclose($fh);
	}
	/**
	 * @param int $serverID
	 * @return void
	 */
	public function removeAdminGroupAsAdminOfServer($adminGroupID, $serverID)
	{
		$lines = file($this->filepath_adminGroupServerAssoc);
		$fh = fopen($this->filepath_adminGroupServerAssoc, 'w');
		foreach ($lines AS $line) {
			$data = HelperFunctions::stripNewline($line);
			$assoc = explode(';', $line);
			if ($assoc[0] != $adminGroupID || $assoc[1] != $serverID) {
				fputs($fh, $line);
			}
		}
		fclose($fh);
	}
	/**
	 * @param int $groupID
	 * @return array
	 */
	public function getAdminGroupServers($groupID)
	{
		$servers = array();
		$fh = fopen($this->filepath_adminGroupServerAssoc, 'r');
		while ($line = fgets($fh)) {
			$line = HelperFunctions::stripNewline($line);
			$assoc = explode(';', $line);
			if (intval($assoc[0]) == $groupID) {
				$servers[] = $assoc[1];
			}
		}
		fclose($fh);
		sort($servers);
		return $servers;
	}
	/**
	 * @param int $adminId
	 * @return array list of serverIds
	 */
	public function getAdminGroupServersByAdminId($adminId)
	{
		$groups = $this->getAdminGroupsByAdminID($adminId);
		$servers=array();
		foreach ($groups as $group) {
			$srvs = $this->getAdminGroupServers($group['id']);
			foreach ($srvs as $srv) {
				if (!in_array($srv, $servers)) {
					$servers[] = $srv;
				}
			}
		}
		return $servers;
	}

}

// TODO: implement MySQL (?)
//class DBManager_mysql

// TODO: implement PostgreSQL (?)
//class DBManager_psql

// TODO: implement SQLite (?)
//class DBManager_sqlite
