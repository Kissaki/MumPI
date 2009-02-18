<?php

class UserRegistration {
	private $playerid;
	private $name;
	private $email;
	private $pw;
	
	function __construct($playerid, $name, $email, $pw){
		$this->playerid = $playerid;
		$this->name = $name;
		$this->email = $email;
		$this->pw = $pw;
	}
	
	function returnTrue(){
		return true;
	}
	
}



?>