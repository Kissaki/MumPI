<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */

/**
 * Provides murmur server functionality
 */
class ServerInterface{
	private static $instance = null;
	public static function getInstance()
	{
		if(!isset(self::$instance))
		{
			$dbType = SettingsManager::getInstance()->getDbInterfaceType();
			if( class_exists('ServerInterface_'.$dbType) )
			{
				eval('self::$instance = new ServerInterface_'.$dbType.'();');
			}else{
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
	
	function __construct(){
		// Check that the PHP Ice extension is loaded.
		if(!extension_loaded('ice'))
		{
			MessageManager::addError(tr('error_noIceExtensionLoaded'));
		}else{
			try{
				Ice_loadProfile();
				$this->connect();
			}catch(Ice_ProfileAlreadyLoadedException $exc){
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
	public function getVersion(){
		unset($major); unset($minor); unset($patch); unset($text);
		$this->meta->getVersion($major, $minor, $patch, $text);
		return $major.'.'.$minor.'.'.$patch.' '.$text;
	}
	/**
	 * 
	 * @return Array with name=>value
	 */
	public function getDefaultConfig(){
		return $this->meta->getDefaultConf();
	}
	/**
	 * Get all virtual servers
	 * @return unknown_type all virtual servers
	 */
	public function getServers(){
		$servers = $this->meta->getAllServers();
		return $servers;
	}
	/**
	 * Get all running virtual servers
	 * @return unknown_type all running virtual servers
	 */
	public function getRunningServers(){
		$servers = $this->meta->getBootedServers();
		return $servers;
	}
	/**
	 * Get a specific virtual server
	 * @param $srvid server id
	 * @return unknown_type (virtual) server
	 */
	public function getServer($srvid){
		return $this->meta->getServer(intval($srvid));
	}
	/**
	 * Create a new virtual server. Will return the created servers id.
	 * @return int server id
	 */
	public function createServer(){
		return $this->meta->newServer()->id();
	}
	
	
	
	// Virtual Server
	
	/**
	 * Is the virtual server currently running?
	 * @param $sid server id
	 * @return boolean
	 */
	public function isRunning($sid){
		return self::getServer($sid)->isRunning();
	}
	/**
	 * Start a specific virtual server
	 * @param $sid server id
	 */
	public function startServer($sid){
		self::getServer($sid)->start();
	}
	/**
	 * Stop a specific running virtual server
	 * @param $sid server id
	 */
	public function stopServer($sid){
		self::getServer($sid)->stop();
	}
	/**
	 * Delete a virtual server with all it's configuration settings
	 * @param $sid server id
	 */
	public function deleteServer($sid){
		if($this->isRunning($sid))
			$this->stopServer($sid);
		$this->getServer($sid)->delete();
	}
	//TODO implement callbacks (add, remove)
	//TODO setAuthenticator(ServerAuthenticator* auth)
	
	public function getServerConfigEntry($sid, $key){
		return $this->getServer($sid)->getConf($key);
	}
	public function getServerConfig($sid){
		// As an unset config entry will fall back to the default config, we will get the default config and overwrite/add it with server specific settings
		$conf = $this->getDefaultConfig();
		$confS = $this->getServer($sid)->getAllConf();
		foreach($confS AS $key=>$val)
		{
			$conf[$key] = $val;
		}
		return $conf;
	}
	public function setServerConfigEntry($sid, $key, $newValue){
		$this->getServer($sid)->setConf($key, $newValue);
	}
	
	public function setServerSuperuserPassword($sid, $newPw){
		$this->getServer($sid)->setSuperuserPassword($newPw);
	}
	
	/**
	 * 
	 * @param $sid server id
	 * @param $first Lowest numbered entry to fetch. 0 is the most recent item.
	 * @param $last Last entry to fetch.
	 * @return array(string) log entries
	 */
	public function getServerLog($sid, $first=25, $last=0){
		return $this->getServer($sid)->getLog($first, $last);
	}
	
	
	/**
	 * Get all user registrations of the virtual server
	 * @param $sid
	 * @param $filter a filter
	 * @return sequence of registrations
	 */
	public function getServerRegistrations($sid, $filter=''){
		return $this->getServer($sid)->getRegisteredPlayers($filter);
	}
	/**
	 * Get connected users of a virtual server
	 * @param $sid
	 * @return array[pid] Array with user id as key and user name as value  
	 */
	public function getServerUsersConnected($sid){
		return $this->getServer($sid)->getPlayers();
	}
	/**
	 * Get a user registration from a virtual server
	 * @param $srvid
	 * @param $uid
	 * @return unknown_type
	 */
	public function getServerUser($srvid, $uid){
		return $this->getServer(intval($srvid))->getRegistration(intval($uid));
	}
	/**
	 * Get a user account by searching for a specific email.
	 * This will only return the first user account found.
	 * @param $srvid server id
	 * @param $email email address
	 * @return unknown_type registration or null
	 */
	function getUserByEmail($srvid, $email){
		$regs = $this->getServer($srvid)->getRegisteredPlayers('');
		foreach($regs AS $reg){
			if($reg->email == $email){
				return $reg;
			}
		}
		return null;
	}
	function getUserName($srvid, $uid){
		return $this->getServerUser($srvid,$uid)->name;
	}
	function getUserEmail($srvid, $uid){
		return $this->getServerUser($srvid,$uid)->email;
	}
	function getUserPw($srvid, $uid){
		return $this->getServerUser($srvid,$uid)->pw;
	}
	function getUserTexture($srvid, $uid){
		return $this->getServer($srvid)->getTexture(intval($uid));
	}
	
	function addUser($srvid, $name, $password, $email=''){
		try{
			$tmpServer = ServerInterface::getInstance()->getServer(intval($srvid));
			if(empty($tmpServer)){
				echo 'Server could not be found.<br/>';
				die();
			}
			$tmpUid = $tmpServer->registerPlayer($name);
			$tmpReg = $tmpServer->getRegistration($tmpUid);
			$tmpReg->pw = $password;
			if(!empty($email))
				$tmpReg->email = $email;
			$tmpReg = $tmpServer->updateregistration($tmpReg);
			echo TranslationManager::getInstance()->getText('doregister_success').'<br/>';
		}catch(Murmur_InvalidServerException $exc){	// This is depreciated (murmur.ice)
			echo 'Invalid server. Please check your server selection.<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a><br/>If the problem persists, please contact a server admin or webmaster.<br/>';
		}catch(Murmur_ServerBootedException $exc){
			echo 'Server is currently not running, but it has to to be able to register.<br/>Please contact a server admin';
		}catch(Murmur_InvalidPlayerException $exc){
			echo 'The username you specified is probably already in use or invalid. Please try another one.<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
		}catch(Ice_UnknownUserException $exc){	// This should not be caught
			echo $exc->unknown.'<br/>';
//			echo '<pre>'; var_dump($exc); echo '</pre>';
		}
	}
	function removeRegistration($srvid, $uid){
		ServerInterface::getInstance()->getServer(intval($srvid))->unregisterPlayer(intval($uid));
	}
	
	function updateUserName($srvid, $uid, $newName){
		$srv = $this->getServer($srvid);
		$reg = $srv->getRegistration(intval($uid));
		$reg->name = $newName;
		$srv->updateregistration($reg);
	}
	function updateUserEmail($srvid, $uid, $newEmail){
		$srv = $this->getServer($srvid);
		$reg = $srv->getRegistration(intval($uid));
		$reg->email = $newEmail;
		$srv->updateregistration($reg);
	}
	function updateUserPw($srvid, $uid, $newPw){
		$srv = $this->getServer($srvid);
		$reg = $srv->getRegistration($uid);
		$reg->pw = $newPw;
		$srv->updateregistration($reg);
	}
	function updateUserTexture($srvid, $uid, $newTexture){
		try{
			if(is_string($newTexture)){
				// conversation string -> byte array (PHP5)
				$newTexture = str_split($newTexture);
			}
			$this->getServer($srvid)->setTexture($uid, $newTexture);
			return true;
		}catch(Murmur_InvalidTextureException $exc){
			MessageManager::addError(tr('error_invalidTexture'));
			return false;
		}
	}
	function muteUser($srvid, $sessid){
		$srv = $this->meta->getServer(intval($srvid));
		$player = $srv->getState(intval($sessid));
		$player->mute = true;
		$srv->setState($player);
	}
	function unmuteUser($srvid, $sessid){
		$srv = $this->meta->getServer(intval($srvid));
		$player = $srv->getState(intval($sessid));
		$player->deaf = false;
		$player->mute = false;
		$srv->setState($player);
	}
	function deafUser($srvid, $sessid){
		$srv = $this->meta->getServer(intval($srvid));
		$player = $srv->getState(intval($sessid));
		$player->deaf = true;
		$srv->setState($player);
	}
	function undeafUser($srvid, $sessid){
		$srv = $this->meta->getServer(intval($srvid));
		$player = $srv->getState(intval($sessid));
		$player->deaf = false;
		$srv->setState($player);
	}
	function kickUser($srvid, $sessid, $reason=''){
		$this->meta->getServer(intval($srvid))->kickPlayer(intval($sessid), $reason);
	}
	function banUser($srvid, $sessid, $reason=''){
		//TODO implement ban
		$srv = $this->meta->getServer(intval($srvid));
		$bans = $srv->getBans();
		$newBan['address'] = 255255255255;
		$newBan['bits'] = 32;
		$bans[] = $newBan;
		$srv->setBans($bans);
		kickPlayer(intval($sessid), $reason);
	}
	function getServerBans($srvid){
		return $this->meta->getServer(intval($srvid))->getBans();
	}
	
	function verifyPassword($serverid,$uname,$pw){
		return $this->getServer(intval($serverid))->verifyPassword($uname,$pw);
	}
}

?>