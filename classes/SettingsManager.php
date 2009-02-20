<?php
class SettingsManager {
	private static $instance;
	
	public static function getInstance($obj=NULL){
		if(!empty($instance))
			echo 'not empty';
		
		if(!isset($instance))
			if(!isset($obj))
				$instance = new SettingsManager();
			else
				$instance = $obj;
			return $instance;
	}
	
	private $site;
	
	function __construct(){
		
	}
	
	function test(){
		return 'success';
	}
}
?>