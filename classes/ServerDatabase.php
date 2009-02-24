<?php

interface IServerDatabase {
	public function getVersion();
	/*public function getServers();
	public function getServerById($sid);
	public function getRunningServers($sid);
	public function getUsers();
	public function getUserById($uid);
	public function getUserByName($name);
	public function getUserByEmail($email);
	public function createServer();
	*/
	public function addUser($serverid, $name, $password, $email='');
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
}

?>