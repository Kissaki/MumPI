<?php
class HelperFunctions{
	// TODO rename "section" to "page"
	public static function getActivePage(){
		if(isset($_GET['page'])){
			return $_GET['page'];
		}else{
			return 'index';
		}
		
	}
	public static function getActiveSection(){
		if(defined('MUMPHPI_SECTION')){
			return MUMPHPI_SECTION;
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