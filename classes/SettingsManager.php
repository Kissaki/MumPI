<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */

/**
 * The SettingsManager class is an interface to the settings.
 * @author Jan Klass
 */
class SettingsManager {
	private static $instance;
	public static function getInstance(){	// $obj=NULL){
		if(!isset(self::$instance))
			if(!isset($obj))
				self::$instance = new SettingsManager();
			else
				self::$instance = $obj;
		return self::$instance;
	}

	private $isDebugMode;
	private $mainDir;
	private $mainUrl;
	private $theme;
	private $defaultLanguage;
	private $site;
	private $dbType;
	private $dbInterface_type;
	private $dbInterface_address;
	private $numberOfServers;
	private $servers;
	
	function __construct(){

		eval(self::getSettingsFileContents());
		
		$this->isDebugMode = $debug;
		$this->mainDir = MUMPHPI_MAINDIR;
		$this->mainUrl = MUMPHPI_MAINDIR;
		$this->dbInterface_type = $dbInterface_type;
		$this->dbInterface_address = $dbInterface_address;
		$this->theme = $theme;
		$this->defaultLanguage = $defaultLanguage;
		$this->dbType = $dbType;
		
		$this->site = array();
		$this->site['title'] = $site_title;
		$this->site['description'] = $site_description;
		$this->site['keywords'] = $site_keywords;
		
		$this->servers = $servers;
		
		foreach($this->servers AS $server){
			if($server['authbymail']){
				$server['forcemail'] = true;
			}
		}
	}
	
	/**
	 * Parse a settings file to use the values it specifies
	 * @return array with settingname=>value (key being the settingname and the value being its value)
	 */
	private static function getSettingsFileContents($filename=null){

		if($filename==null)
			$filename = 'settings.inc.php';
		
		if(file_exists(MUMPHPI_MAINDIR.'/'.$filename)){
			$settings = file_get_contents(MUMPHPI_MAINDIR.'/'.$filename);
		}else{
			$settings = file_gut_contents(MUMPHPI_MAINDIR.'/settings.inc.default.php');
			self::setSettingsFileContents($settings);
		}
		$settings = substr($settings, 5, strlen($settings)-7);	// strip php tags;
		return $settings;
		
	}
	private static function setSettingsFileContents($settings_content, $filename=null)
	{
		if($filename==null)
			$filename = 'settings.inc.php';
		
		if(file_exists(MUMPHPI_MAINDIR.'/'.$filename)){
			$settings = file_put_contents(MUMPHPI_MAINDIR.'/'.$filename, $settings_content);
		}
		
	}
	
	/**
	 * @return string local main dir of the interface WITHOUT trailing slash
	 */
	function getMainDir(){
		return $this->mainDir;
	}
	function getMainUrl(){
		return $this->mainUrl;
	}
	/**
	 * @return theme name
	 */
	function getTheme(){
		return $this->theme;
	}
	/**
	 * 
	 * @return path to theme without trailing slash (theme/ + themename)
	 */
	function getThemePath(){
		return 'themes/'.HelperFunctions::getActiveSection().'/'.$this->theme;
	}
	/**
	 * 
	 * @return theme directoy on server filesystem
	 */
	function getThemeDir(){
		return $this->mainDir.'/'.$this->getThemePath();
	}
	function getThemeUrl(){
		return $this->mainUrl.'/'.$this->getThemePath();
	}
	/**
	 * Get default language
	 * @return string default language (eg: en or de)
	 */
	function getDefaultLanguage(){
		return $this->defaultLanguage;
	}
	function getDbInterfaceType(){
		return $this->dbInterface_type;
	}
function getDbInterface_address(){
		return $this->dbInterface_address;
	}
	function getDbType(){
		return $this->dbType;
	}
	function getSiteTitle(){
		return $this->site['title'];
	}
	function getSiteDescription(){
		return $this->site['description'];
	}
	function getSiteKeywords(){
		$this->site['keywords'];
	}
	function getNumberOfServers(){
		return $this->numberOfServers;
	}
	function getServers(){
		return $this->servers;
	}
	function getServerName($serverid){
		if(!isset($this->servers[$serverid])){
			return null;
		}
		return $this->servers[$serverid]['name'];
	}
	
	function isForceEmail($serverid){
		for($i=0; $i<$this->numberOfServers; $i++){
			if( $this->servers[$i]['id'] == $serverid ){
				return $this->servers[$i]['forcemail'];
			}
		}
		return null;	// no such server (TODO: implement exception?)
	}
	function isAuthByMail($serverid){
		for($i=0; $i<$this->numberOfServers; $i++){
			if($this->servers[$i]['id'] == $serverid){
				return $this->servers[$i]['authbymail'];
			}
		}
		return null;	// no such server (TODO: implement exception?)
	}
	function isDebugMode(){
		return $this->isDebugMode;
	}
	
	
	function setServerInformation($serverid, $name, $allowlogin=true, $allowregistration=true, $forcemail=true, $authbymail=true)
	{
		if(isset($this->servers[$serverid]))
		{
			
		}else{
			
		}
		/*
		if($this->getServerName($serverid) == null){
			//if server info does not exist yet, add it
			$file = file_get_contents($this->getMainDir().'settings.inc.php');
			$index_key = strstr($file, 'server_numberOfServers');
			$file_part1 = substr($file, 0, $index_key);
			$file_part2 = substr($file, $index_key);
			$index_nl = strstr($file_part2, "\n");
			$file_part2 = substr($file_part2, $index_nl);
			$file = $file.'';
			file_put_contents($this->getMainDir().'settings.inc.php', $file);
		}*/
	}
}
?>