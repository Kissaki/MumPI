<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */
//TODO language folder should be in templates, so they can have their own strings
/**
 * The TranslationManager class provides an interface to get translated text.
 * @author Kissaki
 */
class TranslationManager {		// To make calls shorter in code, the class _Instance was created so static functions with the same name can be used
	private static $instance;
	public static function getInstance(){	// $obj=null){
		if(!isset(self::$instance))
			if(!isset($obj))
				self::$instance = new TranslationManager_Instance();
			else
				self::$instance = $obj;
		return self::$instance;
	}
	public static function getText($textname){
		$txt = self::getInstance()->getText($textname);
		if(!isset($txt))
			return 'unknown string';
		return $txt;
	}
	public static function echoText($textname){
		echo self::getText($textname);
	}
	
}

class TranslationManager_Instance{
	private $language;
	private $defaultLanguage;
	private $text;
	
	public function __construct(){
		$this->defaultLanguage = SettingsManager::getInstance()->getDefaultLanguage();
		if( isset($_GET['lang']) && !empty($_GET['lang']) ){
			$this->language = $_GET['lang'];
		}elseif( ($ses_lang = SessionManager::getInstance()->getLanguage())!=null ){
			$this->language = $ses_lang;
		}else{
			$this->language = $this->defaultLanguage;
		}
		
		// TODO add check, if translation files are recent version
		$txt = array();
		// Parse Main lang file
		eval(self::parseLanguageFile($this->language));
		
		// Parse Section lang file
		eval(self::parseLanguageFile($this->language, HelperFunctions::getActiveSection()));
		
		// Parse Page lang file (if exists)
		eval(self::parseLanguageFile($this->language, HelperFunctions::getActiveSection(), HelperFunctions::getActivePage()));
		
		$this->text = $txt;
	}
	
	public function getActiveLanguage(){
		return $this->language;
	}
	/**
	 * Get the default language of the interface.
	 * @return unknown_type
	 */
	public function getDefaultLanguage(){
		return $this->defaultLanguage;
	}
	public function getText($textname){
		if(!isset($this->text[$textname]))
			return 'unknown string';
		return $this->text[$textname];
	}
	
/**
	 * Get a specific language file as a string for evaluation (eval()).
	 * @param $language	The language to try to parse.
	 * @param $section	the section to parse (if applicable)
	 * @param $page		the page to parse for (if applicable)
	 * @return string	String holding the anguage file information.
	 */
	private static function parseLanguageFile($language, $section=null, $page=null){
		$langfile = '';
		$filename = SettingsManager::getInstance()->getMainDir().'/languages/'.$language;
		$fallback = SettingsManager::getInstance()->getMainDir().'/languages/'.SettingsManager::getInstance()->getDefaultLanguage();
		if($section==null){
			$filename = $filename.'/main.lang.php';
			$fallback = $fallback.'/main.lang.php';
		}elseif($page==null){
			$filename = $filename.'/'.$section.'.lang.php';
			$fallback = $fallback.'/'.$section.'.lang.php';
		}else{
			$filename = $filename.'/'.$section.'/'.$page.'.lang.php';
			$fallback = $fallback.'/'.$section.'/'.$page.'.lang.php';
		}
		// Parse file
		if(file_exists($filename)){
			$langfile = file_get_contents($filename);
			$langfile = substr($langfile, 5, strlen($langfile)-7);	// strip php tags
		}elseif(file_exists($fallback)){
			$langfile = file_get_contents($fallback);
			$langfile = substr($langfile, 5, strlen($langfile)-7);	// strip php tags
		}
		return $langfile;
	}
}
?>