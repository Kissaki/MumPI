<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */

/**
 * Permissionmanager for managing permissions,
 * asking for permission…
 */
class PermissionManager
{
	private static $instance;
	
	/**
	 * Get the object of the PermissionManager, specific to the section
	 * @return PermissionManager_admin
	 */
	public static function getInstance()
	{
		if(self::$instance == null){
			$section = HelperFunctions::getActiveSection();
			if (class_exists('PermissionManager_' . $section)) {
				eval('self::$instance = new PermissionManager_' . $section . '();');
			} else {
				echo 'Unknown Permission Manager';
			}
		}
		return self::$instance;
	}
	
}

/**
 * PermissionManager for admin section
 */
class PermissionManager_admin
{
	private $perms;
	private $servers;
	private $isGlobalAdmin;
	
	public function __construct()
	{
		if (SessionManager::getInstance()->isAdmin()) {
			$aid = SessionManager::getInstance()->getAdminID();
			$admin = DBManager::getInstance()->getAdmin($aid);
			$this->isGlobalAdmin = $admin['isGlobalAdmin'];
			$this->perms = DBManager::getInstance()->getAdminGroupPermissionsByAdminID($aid);
			$this->servers = DBManager::getInstance()->getAdminGroupServersByAdminId($aid);
		} else {
			$this->isGlobalAdmin = false;
			$this->perms = DBManager::$defaultAdminGroupPerms;
			$this->servers = array();
		}
	}
	
	/**
	 * Is global admin?
	 * Can administrate all servers, add and remove virtual servers
	 * @return boolean
	 */
	public function isGlobalAdmin()
	{
		return $this->isGlobalAdmin;
	}
	
	/**
	 * Is the admin an admin of that server?
	 * @param int $serverId
	 * @return bool
	 */
	public function isAdminOfServer($serverId)
	{
		return $this->isGlobalAdmin || in_array($serverId, $this->servers);
	}
	
	/**
	 * Can start and stop servers?
	 * @param $sid
	 * @return boolean
	 */
	public function serverCanStartStop($sid=null)
	{
		return $this->isGlobalAdmin || ($this->perms['startStop'] && in_array($sid, $this->servers));
	}
	
	/**
	 * Can edit the (virtual) servers (config) settings?
	 * @param $sid
	 * @return boolean
	 */
	public function serverCanEditConf($sid)
	{
		return $this->isGlobalAdmin || ($this->perms['editConf'] && in_array($sid, $this->servers));
	}
	
	/**
	 * Can generate a new superuser password?
	 * @param $sid
	 * @return boolean
	 */
	public function serverCanGenSuUsPW($sid)
	{
		return $this->isGlobalAdmin || ($this->perms['genSuUsPW'] && in_array($sid, $this->servers));
	}
	
	/**
	 * Can view registrations / accounts on the server?
	 * @param $sid
	 * @return boolean
	 */
	public function serverCanViewRegistrations($sid)
	{
		return $this->isGlobalAdmin || ($this->perms['viewRegistrations'] && in_array($sid, $this->servers));
	}
	
	/**
	 * Can edit user accounts?
	 * @param $sid
	 * @return boolean
	 */
	public function serverCanEditRegistrations($sid)
	{
		return $this->isGlobalAdmin || ($this->perms['editRegistrations'] && in_array($sid, $this->servers));
	}
	
	/**
	 * Can create channels, Move users?
	 * @return boolean
	 */
	public function serverCanModerate($sid)
	{
		return $this->isGlobalAdmin || ($this->perms['moderate'] && in_array($sid, $this->servers));
	}
	
	/**
	 * Can kick online users?
	 * @param $sid
	 * @return boolean
	 */
	public function serverCanKick($sid)
	{
		return $this->isGlobalAdmin || ($this->perms['kick'] && in_array($sid, $this->servers));
	}
	
	/**
	 * Can ban users?
	 * @param $sid
	 * @return boolean
	 */
	public function serverCanBan($sid)
	{
		return $this->isGlobalAdmin || ($this->perms['ban'] && in_array($sid, $this->servers));
	}

	/**
	 * @return boolean
	 */
	public function serverCanEditChannels($sid)
	{
		return $this->isGlobalAdmin || ($this->perms['channels'] && in_array($sid, $this->servers));
	}
	
	/**
	 * @return boolean
	 */
	public function serverCanEditACLs($sid)
	{
		return $this->isGlobalAdmin || ($this->perms['acls'] && in_array($sid, $this->servers));
	}
	
	/**
	 * @return boolean
	 */
	public function serverCanEditAdmins($sid=null)
	{
		return $this->isGlobalAdmin || ($this->perms['admins'] && in_array($sid, $this->servers));
	}
}

?>