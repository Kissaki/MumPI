<?php
require_once(MUMPHPI_MAINDIR.'/classes/SessionManager.php');

/**
 * Global function for easier access
 * @param $key Language Translation key
 * @return string text value (translated)
 */
function tr($key)
{
	return TranslationManager::getText($key);
}

//TODO language folder should be in templates folder (as well), so they can have their own strings
/**
 * The TranslationManager class provides an interface to get translated text.
 * @author Kissaki
 */
class TranslationManager
{
	// To make calls shorter in code, the class _Instance was created so static functions with the same name can be used
	private static $instance;

	/**
	 * Get the TranslationManager instance
	 * create it if necessary
	 * @return TranslationManager_Instance
	 */
	public static function getInstance()
	{	// $obj=null){
		if (!isset(self::$instance)) {
			if (!isset($obj)) {
				self::$instance = new TranslationManager_Instance();
			} else {
				self::$instance = $obj;
			}
		}
		return self::$instance;
	}

	public static function getText($textname){
		$txt = self::getInstance()->getText($textname);
		return $txt;
	}

}

/**
 * Translationmanager Instance
 * @author Kissaki
 */
class TranslationManager_Instance
{
	private $language;
	private $defaultLanguage;
	private $text;

	public function __construct()
	{
		$this->defaultLanguage = SettingsManager::getInstance()->getDefaultLanguage();
		// get lang setting from URL param, session or use default
		if (!empty($_GET['lang'])) {
			$this->language = $_GET['lang'];
		} elseif (($ses_lang = SessionManager::getInstance()->getLanguage())!=null) {
			$this->language = $ses_lang;
		} else {
			$this->language = $this->defaultLanguage;
		}

		$txt = array();
		// Parse Main lang file
		eval(self::parseLanguageFile($this->language));

		// Parse Section lang file
		eval(self::parseLanguageFile($this->language, HelperFunctions::getActiveSection()));

		// Parse Page lang file (if exists)
		eval(self::parseLanguageFile($this->language, HelperFunctions::getActiveSection(), HelperFunctions::getActivePage()));

		$this->text = $txt;
	}

	/**
	 * Get the currently active language
	 * @return string language
	 */
	public function getActiveLanguage()
	{
		return $this->language;
	}
	/**
	 * Get the default language of the interface.
	 * @return string language
	 */
	public function getDefaultLanguage()
	{
		return $this->defaultLanguage;
	}

	/**
	 * Get the (translated/local) text for the ID / text index
	 * @param $textname text index
	 * @return string localized text
	 */
	public function getText($textname)
	{
		if (!isset($this->text[$textname])) {
			MessageManager::addWarning('Translation for key "'.$textname.'" not found!');
			return '???';
		}
		return $this->text[$textname];
		// w3c validator doesn't like html (tags) in javascript areas. maybe, or not:
		//return htmlspecialchars($this->text[$textname]);
	}

/**
	 * Get a specific language file as a string for evaluation (eval()).
	 * @param $language	The language to try to parse.
	 * @param $section	the section to parse (if applicable)
	 * @param $page		the page to parse for (if applicable)
	 * @return string	String holding the anguage file information.
	 */
	private static function parseLanguageFile($language, $section=null, $page=null)
	{
		$langfile = '';
		$filename = SettingsManager::getInstance()->getMainDir().'/languages/'.$language;
		$fallback = SettingsManager::getInstance()->getMainDir().'/languages/'.SettingsManager::getInstance()->getDefaultLanguage();
		if ($section==null) {
			$filename = $filename.'/main.lang.php';
			$fallback = $fallback.'/main.lang.php';
		} elseif ($page==null) {
			$filename = $filename.'/'.$section.'.lang.php';
			$fallback = $fallback.'/'.$section.'.lang.php';
		} else {
			$filename = $filename.'/'.$section.'/'.$page.'.lang.php';
			$fallback = $fallback.'/'.$section.'/'.$page.'.lang.php';
		}
		// Parse file
		if (file_exists($filename)) {
			$langfile = file_get_contents($filename);
		} elseif (file_exists($fallback)) {
			$langfile = file_get_contents($fallback);
		}
		// strip php tags
		$langfile = str_replace('<?php', '', $langfile);
		$langfile = str_replace('?>', '', $langfile);
		return $langfile;
	}
}
