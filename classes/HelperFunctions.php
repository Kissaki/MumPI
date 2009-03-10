<?php
class HelperFunctions{
	// TODO rename "section" to "page"
	public static function getActivePage(){
		if(isset($_GET['section'])){
			return $_GET['section'];
		}else{
			return 'index';
		}
		
	}
	public static function getActiveSection(){
		switch(basename($_SERVER['SCRIPT_FILENAME'])){
			case 'index.php':
				return 'user';
			case 'admin.php':
				return 'admin';
		}
		return null;
	}
	
	public static function getCurrentUrl(){
		return $_SERVER['REQUEST_URI'];
	}
	
	public static function getReferer(){
		return $_SERVER['HTTP_REFERER'];
	}
	public static function getVisitorIP(){
		return $_SERVER['REMOTE_ADDR'];
	}
	public static function getVisitorHost(){
		return $_SERVER['REMOTE_HOST'];
	}
	
	
}
?>