<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */

class SessionManager{
	private static $instance;
	/**
	 * starts a php session
	 */
	public static function startSession(){
		if(!isset(self::$instance)){
			self::$instance = new SessionManager_obj();
		}
	}
	public static function getInstance(){
		if(self::$instance==null){
			self::$instance = new SessionManager_obj();
		}
		return self::$instance;
	}
	
	
}

class SessionManager_obj{
	public function __construct(){
		session_start();
	}
	/**
	 * Checks if the visitor is logged in to a mumble user account (on a specific server)
	 * @return boolean
	 */
	public function isUser(){
		if(isset($_SESSION['userLoggedIn'])){
			return true;
		}
		return false;
	}
	/**
	 * Check if the visitor is logged in as an interface admin
	 * @return boolean
	 */
	public function isAdmin(){
		if(isset($_SESSION['adminLoggedIn'])){
			return true;
		}
		return false;
	}
	
	public function getLanguage(){
		if(isset($_SESSION['language'])){
			return $_SESSION['language'];
		}else{
			return null;
		}
	}
}

?>