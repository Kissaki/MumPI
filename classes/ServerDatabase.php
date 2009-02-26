<?php

interface IServerDatabase {
	public function getVersion();
	public function getServers();
	public function getServer($sid);
//	public function getRunningServers($sid);
//	public function getUsers();
//	public function getUserById($uid);
//	public function getUserByName($name);
//	public function getUserByEmail($email);
//	public function createServer();
	public function addUser($serverid, $name, $password, $email='');
}

class ServerDatabase{
	private static $instance;
	public static function getInstance($obj=NULL){
		if(!isset(self::$instance)){
			if(!isset($obj)){
				if(SettingsManager::getInstance()->getDbInterfaceType() == 'ice'){
					if(!extension_loaded('ice')) die('<div class="error"><b>Error</b>: Could not find loaded ice extension.<br/><br/>Please check <a href="http://mumble.sourceforge.net/ICE">the ICE page in the mumble wiki</a> if you don\'t know what to do.</div>');
					self::$instance = new ServerDatabase_ICE();
				}else{
					die('Misconfiguration: Unknown <acronym title="database">DB</acronym> Interface Type!');
				}
//				$dbType = SettingsManager::getInstance()->getDbInterfaceType();
//				switch($dbType){
//					case 'ICE': 
//						self::$instance = new ServerDatabase_ICE();
//						break;
//				}
//				die('Unknown DB Type. Check your configuration!');
			}else{
				self::$instance = $obj;
			}
		}
		return self::$instance;
	}
	
}

class ServerDatabase_ICE implements IServerDatabase {
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
		Ice_loadProfile();
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
	
	function verifyPassword($serverid,$uname,$pw){
		return $this->meta->getServer(intval($serverid))->verifyPassword($uname,$pw);
	}
}

?>