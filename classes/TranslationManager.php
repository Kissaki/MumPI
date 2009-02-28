<?php
/**
 * The TranslationManager class provides an interface to get translated text.
 * @author Jan Klass
 */
class TranslationManager {
	private static $instance;
	public static function getInstance($obj=null){
		if(!isset(self::$instance))
			if(!isset($obj))
				self::$instance = new TranslationManager();
			else
				self::$instance = $obj;
		return self::$instance;
	}
	
	private $text;
	
	private function __construct(){
		global $txt;
		include(SettingsManager::getInstance()->getMainDir().'/languages/'.SettingsManager::getInstance()->getLanguage().'.php');
		$this->text = $txt;
	}
	function __autoload($class_name) {
		require_once $class_name.'.php';
	}
	
	function getText($textname){
		if(!isset($this->text[$textname]))
			return 'unknown string';
		return $this->text[$textname];
	}
}
?>