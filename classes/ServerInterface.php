<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */

require_once dirname(__FILE__).'/PermissionManager.php';
require_once dirname(__FILE__).'/MurmurClasses.php';

/**
 * Provides murmur server functionality
 */
class ServerInterface{
	private static $instance = null;
	
	/**
	 * @return ServerInterface_ice
	 */
	public static function getInstance()
	{
		if (!isset(self::$instance)) {
			$dbType = SettingsManager::getInstance()->getDbInterfaceType();
			if ( class_exists('ServerInterface_'.$dbType) ) {
				eval('self::$instance = new ServerInterface_'.$dbType.'();');
			} else {
				MessageManager::addError(tr('error_unknowninterface'));
			}
		}
		return self::$instance;
	}
	
}

class ServerInterface_ice
{
	private $conn;
	private $meta;
	
	function __construct()
	{
		// Check that the PHP Ice extension is loaded.
		if (!extension_loaded('ice')) {
			MessageManager::addError(tr('error_noIceExtensionLoaded'));
		} else {
			try {
				Ice_loadProfile();
				$this->connect();
			} catch(Ice_ProfileAlreadyLoadedException $exc) {
				MessageManager::addError(tr('iceprofilealreadyloaded'));
			}
		}
	}
	
	private function connect()
	{
		global $ICE;
		$this->conn = $ICE->stringToProxy(SettingsManager::getInstance()->getDbInterface_address());
		// it would be good to be able to add a check if slice file is loaded
		//MessageManager::addError(tr('error_noIceSliceLoaded'));
		$this->meta = $this->conn->ice_checkedCast("::Murmur::Meta");	// May throw exception
		$this->meta = $this->meta->ice_timeout(10000);
	}
	
	//Meta
	/**
	 * Get servers version.
	 * @return string version
	 */
	public function getVersion()
	{
		unset($major); unset($minor); unset($patch); unset($text);
		$this->meta->getVersion($major, $minor, $patch, $text);
		return $major.'.'.$minor.'.'.$patch.' '.$text;
	}
	/**
	 * 
	 * @return Array with name=>value
	 */
	public function getDefaultConfig()
	{
		return $this->meta->getDefaultConf();
	}
	/**
	 * Get all virtual servers
	 * @return unknown_type all virtual servers
	 */
	public function getServers()
	{
		$servers = $this->meta->getAllServers();
		$filtered = array();
		foreach ($servers as $server) {
			if (HelperFunctions::getActiveSection()!='admin' || PermissionManager::getInstance()->isAdminOfServer($server->id()))
				$filtered[] = $server;
		}
		return $filtered;
	}
	/**
	 * Get all running virtual servers
	 * @return unknown_type all running virtual servers
	 */
	public function getRunningServers()
	{
		$servers = $this->meta->getBootedServers();
		return $servers;
	}
	/**
	 * Get a specific virtual server
	 * @param $srvid server id
	 * @return unknown_type (virtual) server
	 */
	public function getServer($srvid)
	{
		return $this->meta->getServer(intval($srvid));
	}
	/**
	 * Create a new virtual server. Will return the created servers id.
	 * @return int server id
	 */
	public function createServer()
	{
		return $this->meta->newServer()->id();
	}
	
	
	
	// Virtual Server
	
	/**
	 * Is the virtual server currently running?
	 * @param $sid server id
	 * @return boolean
	 */
	public function isRunning($sid)
	{
		return self::getServer($sid)->isRunning();
	}
	/**
	 * Start a specific virtual server
	 * @param $sid server id
	 */
	public function startServer($sid)
	{
		self::getServer($sid)->start();
	}
	/**
	 * Stop a specific running virtual server
	 * @param $sid server id
	 */
	public function stopServer($sid)
	{
		self::getServer($sid)->stop();
	}
	/**
	 * Delete a virtual server with all it's configuration settings
	 * @param $sid server id
	 */
	public function deleteServer($sid)
	{
		if($this->isRunning($sid))
			$this->stopServer($sid);
		$this->getServer($sid)->delete();
	}
	//TODO implement callbacks (add, remove)
	//TODO setAuthenticator(ServerAuthenticator* auth)
	
	public function getServerConfigEntry($sid, $key)
	{
		return $this->getServer($sid)->getConf($key);
	}
	public function getServerConfig($sid)
	{
		// As an unset config entry will fall back to the default config, we will get the default config and overwrite/add it with server specific settings
		$conf = $this->getDefaultConfig();
		$confS = $this->getServer($sid)->getAllConf();
		foreach ($confS as $key=>$val) {
			$conf[$key] = $val;
		}
		return $conf;
	}
	public function setServerConfigEntry($sid, $key, $newValue)
	{
		$this->getServer($sid)->setConf($key, $newValue);
	}
	
	public function setServerSuperuserPassword($sid, $newPw)
	{
		$this->getServer($sid)->setSuperuserPassword($newPw);
	}
	
	/**
	 * 
	 * @param $sid server id
	 * @param $first Lowest numbered entry to fetch. 0 is the most recent item.
	 * @param $last Last entry to fetch.
	 * @return array(string) log entries
	 */
	public function getServerLog($sid, $first=25, $last=0)
	{
		return $this->getServer($sid)->getLog($first, $last);
	}
	
	
	/**
	 * Get all user registrations of the virtual server
	 * @param $sid
	 * @param $filter a filter
	 * @return sequence of registrations
	 */
	public function getServerRegistrations($serverId, $filter='')
	{
		return $this->getServer($serverId)->getRegisteredUsers($filter);
	}
	/**
	 * @param int $serverId
	 * @param int $userId
	 * @return MurmurRegistration
	 */
	public function getServerRegistration($serverId, $userId)
	{
		$server=$this->getServer($serverId);
		if(null===$server)
			throw new Exception('Invalid server id, server not found.');
		return MurmurRegistration::fromIceObject($server->getRegistration($userId));
	}
	/**
	 * Get connected users of a virtual server
	 * @param $sid
	 * @return array[pid] Array with user id as key and user name as value  
	 */
	public function getServerUsersConnected($sid)
	{
		return $this->getServer($sid)->getUsers();
	}
	/**
	 * Get a user registration from a virtual server
	 * @param $srvid
	 * @param $uid
	 * @return MurmurRegistration
	 */
	public function getServerUser($srvid, $uid)
	{
		return MurmurRegistration::fromIceObject($this->getServer(intval($srvid))->getRegistration(intval($uid)));
	}
	/**
	 * Get a user account by searching for a specific email.
	 * This will only return the first user account found.
	 * @param $srvid server id
	 * @param $email email address
	 * @return unknown_type registration or null
	 */
	function getUserByEmail($srvid, $email)
	{
		$regs = $this->getServer($srvid)->getRegisteredPlayers('');
		foreach($regs AS $reg){
			if($reg->email == $email){
				return $reg;
			}
		}
		return null;
	}
	function getUserName($srvid, $uid)
	{
		return $this->getServerUser($srvid, $uid)->getName();
	}
	function getUserEmail($srvid, $uid)
	{
		return $this->getServerUser($srvid, $uid)->getEmail();
	}
	function getUserPw($srvid, $uid)
	{
		return $this->getServerUser($srvid,$uid)->getPassword();
	}
	function getUserTexture($srvid, $uid)
	{
		return $this->getServer($srvid)->getTexture(intval($uid));
	}
	
	function addUser($srvid, $name, $password, $email=null)
	{
		try {
			$tmpServer = ServerInterface::getInstance()->getServer(intval($srvid));
			if (empty($tmpServer)) {
				echo 'Server could not be found.<br/>';
				die();
			}
			
			$reg = new MurmurRegistration($name, $email, null, null, $password);
			$tmpUid = $tmpServer->registerUser($reg->toArray());
			
			echo TranslationManager::getInstance()->getText('doregister_success').'<br/>';
		} catch(Murmur_InvalidServerException $exc) {	// This is depreciated (murmur.ice)
			echo 'Invalid server. Please check your server selection.<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a><br/>If the problem persists, please contact a server admin or webmaster.<br/>';
		} catch(Murmur_ServerBootedException $exc) {
			echo 'Server is currently not running, but it has to to be able to register.<br/>Please contact a server admin';
		} catch(Murmur_InvalidPlayerException $exc) {
			echo 'The username you specified is probably already in use or invalid. Please try another one.<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
		} catch(Ice_UnknownUserException $exc) {	// This should not be caught
			echo $exc->unknown.'<br/>';
//			echo '<pre>'; var_dump($exc); echo '</pre>';
		}
	}
	function removeRegistration($srvid, $uid)
	{
		ServerInterface::getInstance()->getServer(intval($srvid))->unregisterPlayer(intval($uid));
	}
	
	function updateUserName($srvid, $userId, $newName)
	{
		$reg = $this->getServerRegistration($srvid, $userId);
		$reg->setName($newName);
		$this->getServer($srvid)->updateregistration($userId, $reg->toArray());
	}
	function updateUserEmail($srvid, $userId, $newEmail)
	{
		$srv = $this->getServer($srvid);
		$reg = $this->getServerUser($srvid, $userId);
		$reg->setEmail($newEmail);
		$srv->updateregistration($userId, $reg->toArray());
	}
	function updateUserPw($srvid, $userId, $newPw)
	{
		$srv = $this->getServer($srvid);
		$reg = $this->getServerUser($srvid, $userId);
		$reg->setPassword($newPw);
		$srv->updateregistration($userId, $reg->toArray());
	}
	function updateUserTexture($srvid, $uid, $newTexture)
	{
		try {
			if (is_string($newTexture)) {
				// conversation string -> byte array (PHP5)
				$newTexture = str_split($newTexture);
			}
			$this->getServer($srvid)->setTexture($uid, $newTexture);
			return true;
		} catch(Murmur_InvalidTextureException $exc) {
			MessageManager::addError(tr('error_invalidTexture'));
			return false;
		}
	}
	function muteUser($srvid, $sessid)
	{
		$srv = $this->meta->getServer(intval($srvid));
		$player = $srv->getState(intval($sessid));
		$player->mute = true;
		$srv->setState($player);
	}
	function unmuteUser($srvid, $sessid)
	{
		$srv = $this->meta->getServer(intval($srvid));
		$player = $srv->getState(intval($sessid));
		$player->deaf = false;
		$player->mute = false;
		$srv->setState($player);
	}
	function deafUser($srvid, $sessid)
	{
		$srv = $this->meta->getServer(intval($srvid));
		$player = $srv->getState(intval($sessid));
		$player->deaf = true;
		$srv->setState($player);
	}
	function undeafUser($srvid, $sessid)
	{
		$srv = $this->meta->getServer(intval($srvid));
		$player = $srv->getState(intval($sessid));
		$player->deaf = false;
		$srv->setState($player);
	}
	function kickUser($srvid, $sessid, $reason='')
	{
		$this->meta->getServer(intval($srvid))->kickPlayer(intval($sessid), $reason);
	}
	function ban($serverId, $ip, $bits=32)
	{
		if (!is_int($ip)) {
			$ip = HelperFunctions::ip2int($ip);
		}
		
		$srv = $this->meta->getServer(intval($serverId));
		$bans = $srv->getBans();
		$ban = new Murmur_Ban();
	  $ban->address = $ip;
	  $ban->bits = $bits;
		$bans[] = $ban;
		$srv->setBans($bans);
	}
	function unban($serverId, $ipmask, $bits=32)
	{
		$srv = $this->meta->getServer(intval($serverId));
		$bans = $srv->getBans();
		$newBans = array();
		foreach ($bans as $ban)
		{
			if ($ban->address != $ipmask || $ban->bits != $bits) {
				$newBans[] = $ban;
			}
		}
		$srv->setBans($newBans);
	}
	function getServerBans($srvid)
	{
		return $this->meta->getServer(intval($srvid))->getBans();
	}
	function getServerBansIpString($srvid)
	{
		$bans=$this->getServerBans($srvid);
		foreach ($bans as &$ban) {
			$ban->address=HelperFunctions::int2ip($ban->address);
		}
		return $bans;
	}
	
	function verifyPassword($serverid,$uname,$pw)
	{
		return $this->getServer(intval($serverid))->verifyPassword($uname,$pw);
	}
}

?>