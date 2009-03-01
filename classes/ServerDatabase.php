<?php

class ServerDatabase{
	private static $instance;
	public static function getInstance($obj=NULL){
		if(!isset(self::$instance)){
			if(isset($obj)){
				self::$instance = $obj;
			}else{
				$dbType = SettingsManager::getInstance()->getDbInterfaceType();
				if( class_exists('ServerDatabase_'.$dbType) )
					eval('self::$instance = new ServerDatabase_'.$dbType.'();');
				else
					echo TranslationManager::getInstance()->getText('error_db_unknowninterface');
			}
		}
		return self::$instance;
	}
	
}

class ServerDatabase_ICE {
	// mockable singleton
	private static $dbObj;
	public static function getDb($obj=NULL){
		if(!isset($obj))
			if(isset($dbObj)) return $dbObj;
			else{
				$dbObj = new ServerDatabase_ICE();
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
	function getUser($srvid, $uid){
		return $this->getServer($srvid)->getRegistration($uid);
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
		try {
		    
		    
		    $server = $meta->getServer($serverId);
		
		    try
		    {
		    $registrationId = $server->registerPlayer($_GET['uname']);
		    }catch(ServerBootedException $ex){
		      echo '<div style="color:red;">exception when trying to register<br/>Invalid Username?</div>';
		      print_r($ex);
		    }
		    $registration = $server->getRegistration(intval($registrationId));
		//echo '<pre>'; print_r($registration); echo '</pre>';
		    $registration->pw = $_GET['password'];
		    $registration->email = $_GET['email'];
		//echo '<pre>'; print_r($registration); echo '</pre>';
		    $server->updateregistration($registration);
		    
		  } catch (Ice_Exception $ex) {
		    print_r($ex);
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