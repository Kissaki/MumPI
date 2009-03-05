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
	public static function getInstance($obj=NULL){
		if(!isset(self::$instance))
			if(!isset($obj))
				self::$instance = new SettingsManager();
			else
				self::$instance = $obj;
		return self::$instance;
	}
	
	private $mainDir;
	private $mainUrl;
	private $theme;
	private $language;
	private $site;
	private $dbType;
	private $dbInterfaceType;
	private $numberOfServers;
	private $servers;
	private $isDebugMode;
	
	function __construct(){
		$settings = self::parseSettingsFile();
		
		if(!empty($settings['localDir']))
			$this->mainDir = $settings['localDir'];
		else{ $this->mainDir = dirname(dirname(__FILE__)); }
		$this->mainUrl = $settings['url'];
		$this->dbInterfaceType = $settings['dbInterface'];
		$this->theme = $settings['theme'];
		if(isset($_SESSION['language']) && file_exists($this->mainDir.'/languages/'.$_SESSION['language'].'.php') ){
			$this->language = $settings['language'];
		}else{
			$this->language = $settings['language'];
		}
		$this->dbType = $settings['dbType'];
		
		$this->site = array();
		$this->site['title'] = $settings['site_title'];
		$this->site['description'] = $settings['site_description'];
		$this->site['keywords'] = $settings['site_keywords'];
		
		$this->servers = array();
		
		$this->numberOfServers = $settings['server_numberOfServers'];
		for($i=0; $i < $this->numberOfServers; $i++){
			$this->servers[$i]['id']			=	intval($settings['server_'.($i+1).'_serverid']);
			$this->servers[$i]['name']			=	$settings['server_'.($i+1).'_name'];
			$this->servers[$i]['allowlogin']	=	(boolean)$settings['server_'.($i+1).'_allowlogin'];
			$this->servers[$i]['allowregistration']=(boolean)$settings['server_'.($i+1).'_allowregistration'];
			$this->servers[$i]['forcemail']		=	(boolean)$settings['server_'.($i+1).'_forcemail'];
			$this->servers[$i]['authbymail']	=	(boolean)$settings['server_'.($i+1).'_authbymail'];
			if($this->servers[$i]['authbymail'])
				$this->servers[$i]['forcemail'] = true;
		}
	}
	
	/**
	 * Parse a settings file to use the values it specifies
	 * @return array with settingname=>value (key being the settingname and the value being its value)
	 */
	private static function parseSettingsFile($filename=null){
		$set = array();
		
		if(!isset($filename)){
			if(! $fd = fopen('./settings.inc.php', 'r'))
				 if(! $fd = fopen('../settings.inc.php', 'r'))
				 	die('could not find settings file');
			
		}else{
			$fd = fopen($filename, 'r') || die('could not find custom settings file');
		}
		
		fgets($fd);	// skip first line (die() against direct calls)
		while( $line = fgets($fd) ){
			$line = ltrim($line);
			if( $line != '' && substr($line,0,2)!='//'){	// skip on: empty line, comment line
				$lineArray = explode('=', $line, 2);
				$lineArray[0] = rtrim($lineArray[0]);
				$lineArray[1] = trim($lineArray[1]);
				$set[$lineArray[0]] = $lineArray[1];
			}
		}
		
		fclose($fd);
		
		return $set;
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
		return 'themes/'.$this->theme;
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
	function getLanguage(){
		return $this->language;
	}
	function getDbInterfaceType(){
		return $this->dbInterfaceType;
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
		for($i=0; $i<$this->numberOfServers; $i++){
			if( $this->servers[$i]['id'] == $serverid )
				return $this->servers[$i]['name'];
		}
		return null;	// no such server
	}
	
	function isForceEmail($serverid){
		for($i=0; $i<$this->numberOfServers; $i++){
			if( $this->servers[$i]['id'] == $serverid )
				return $this->servers[$i]['forcemail'];
		}
		return null;	// no such server (TODO: implement exception?)
	}
	function isAuthByMail($serverid){
		for($i=0; $i<$this->numberOfServers; $i++){
			if($this->servers[$i]['id'] == $serverid)
				return $this->servers[$i]['authbymail'];
		}
		return null;	// no such server (TODO: implement exception?)
	}
	function isDebugMode(){
		return $this->isDebugMode;
	}
}
?>