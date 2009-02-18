<?php

interface iServerDatabase {
	public function getVersion();
	public function getServers();
	public function getServerById($sid);
	public function getRunningServers($sid);
	public function getUsers();
	public function getUserById($uid);
	public function getUserByName($name);
	public function getUserByEmail($email);
	public function createServer();
	
	public function addUser($serverid, $name, $password, $email);
}

class ServerDatabase_ICE implements IServerDatabase {
	private $conn;
	private $meta;
	
	function __construct(){
		Ice_loadProfile();
		connect();
	}
	
	private function connect(){
		$conn = $ICE->stringToProxy("Meta:tcp -h 127.0.0.1 -p 6502");
		$meta = $base->ice_checkedCast("::Murmur::Meta");
	}
	
	function getServers(){
		$servers = $meta->getAllServers;
		return $servers;
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