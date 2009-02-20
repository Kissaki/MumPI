<?php
/**
 * The TranslationManager class provides an interface to get translated text.
 * @author Jan Klass
 */
class TranslationManager {
	private static $instance;
	public static function getInstance($obj=null){
		if(!isset($instance))
			if(isset($obj))
				$this->instance = $obj;
			else
				$this->instance = new TranslationManager();
		return $instance;
	}
	private function __construct(){
//		SettingsManager::getInstance()->getLanguage();
	}
}
?>