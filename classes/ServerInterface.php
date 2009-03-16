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
	private static $instance;
	public static function getInstance($obj=NULL){
		if(!isset(self::$instance)){
			if(isset($obj)){
				self::$instance = $obj;
			}else{
				$dbType = SettingsManager::getInstance()->getDbInterfaceType();
				if( class_exists('ServerInterface_'.$dbType) )
					eval('self::$instance = new ServerInterface_'.$dbType.'();');
				else
					echo TranslationManager::getInstance()->getText('error_db_unknowninterface');
			}
		}
		return self::$instance;
	}
	
	public static function getVersion(){
		self::getInstance()->getVersion();
	}
	public static function getServers(){
		self::getInstance()->getServers();
	}
	public static function getServer($srvid){
		self::getInstance()->getServer($srvid);
	}
	public static function createServer(){
		return self::getInstance()->createServer();
	}
	public static function isRunning(){
		return self::getInstance()->isRunning();
	}
	
}

class ServerInterface_ICE {
	// mockable singleton
	private static $dbObj;
	public static function getDb($obj=NULL){
		if(!isset($obj))
			if(isset($dbObj)) return $dbObj;
			else{
				$dbObj = new ServerInterface_ICE();
				return $dbObj;
			}
	}
	
	private $conn;
	private $meta;
	
	function __construct(){
		try{
			Ice_loadProfile();
		}catch(Ice_ProfileAlreadyLoadedException $exc){
			echo 'ICE Profile Already Loaded!';
		}
		$this->connect();
	}
	
	private function connect(){
		global $ICE;
		$this->conn = $ICE->stringToProxy("Meta:tcp -h 127.0.0.1 -p 6502");
		try{
			$this->meta = $this->conn->ice_checkedCast("::Murmur::Meta");
		}catch(Ice_UnknownLocalException $ex) {
		    echo '<div class="error"><b>Error</b>: Could not connect to ICE.<br/>Is your server running with ICE? Check your config';
		    //echo '<div class="detail">'.$ex.'</div></div>';
		    die();
  		}
		
	}
	
	public function getVersion(){
		unset($major); unset($minor); unset($patch); unset($text);
		$this->meta->getVersion($major, $minor, $patch, $text);
		return $major.'.'.$minor.'.'.$patch.' '.$text;
	}
	
	function getServers(){
		$servers = $this->meta->getAllServers();
		return $servers;
	}
	function getServer($srvid){
		return $this->meta->getServer(intval($srvid));
	}
	function createServer(){
		return $this->meta->newServer()->id();
	}
	public function isRunning(){
		return $this->meta->isRunning();
	}
	function getUser($srvid, $uid){
		return $this->getServer($srvid)->getRegistration($uid);
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
		return $this->getUser($srvid,$uid)->name;
	}
	function getUserEmail($srvid, $uid){
		return $this->getUser($srvid,$uid)->email;
	}
	function getUserPw($srvid, $uid){
		return $this->getUser($srvid,$uid)->pw;
	}
	function getUserTexture($srvid, $uid){
		return $this->getServer($srvid)->getTexture(intval($uid));
	}
	
	function addUser($serverid, $name, $password, $email=''){
		try{
			$tmpServer = ServerInterface::getInstance()->getServer(intval($serverid));
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
		}catch(InvalidServerException $exc){	// This is depreciated (murmur.ice)
			echo 'Invalid server. Please check your server selection.<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a><br/>If the problem persists, please contact a server admin or webmaster.<br/>';
		}catch(ServerBootedException $exc){
			echo 'Server is currently not running, but it has to to be able to register.<br/>Please contact a server admin';
		}catch(InvalidPlayerException $exc){
			echo 'The username you specified is probably already in use or invalid. Please try another one.<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
		}catch(Ice_UnknownUserException $exc){	// This should not be caught
			echo $exc->unknown.'<br/>';
//			echo '<pre>'; var_dump($exc); echo '</pre>';
		}
	}
	
	function updateUserName($srvid, $uid, $newName){
		$srv = $this->getServer($srvid);
		$reg = $srv->getRegistration($uid);
		$reg->name = $newName;
		$srv->updateregistration($reg);
	}
	function updateUserEmail($srvid, $uid, $newEmail){
		$srv = $this->getServer($srvid);
		$reg = $srv->getRegistration($uid);
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
				// TODO: implement conversation string -> byte array
				
			}else{
				$this->getServer($srvid)->setTexture($uid, $newTexture);
			}
		return true;
		}catch(Murmur_InvalidTextureException $exc){
			echo '<div class="error">failed: invalid texture</div>';
			return false;
		}
	}
	
	function verifyPassword($serverid,$uname,$pw){
		return $this->getServer(intval($serverid))->verifyPassword($uname,$pw);
	}
}

?>