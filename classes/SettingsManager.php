<?php
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
	private $dbInterfaceType;
	private $numberOfServers;
	private $servers;
	
	function __construct(){
		global $muPI_muDir, $muPI_url, $muPI_theme, $muPI_lang, $muPI_dbInterface, $muPI_site, $muPI_sett_server;
		
		$this->mainDir = $muPI_muDir;
		$this->mainUrl = $muPI_url;
		$this->dbInterfaceType = $muPI_dbInterface;
		$this->theme = $muPI_theme;
		if(isset($_SESSION['language']) && file_exists($this->mainDir.'/languages/'.$_SESSION['language'].'.php') ){
			$this->language = $_SESSION['language'];
		}else{
			$this->language = $muPI_lang;
		}
		
		$this->site = array();
		$this->site['title'] = $muPI_site['title'];
		$this->site['description'] = $muPI_site['description'];
		$this->site['keywords'] = $muPI_site['keywords'];
		
		$this->servers = array();
		
		$this->numberOfServers = $muPI_sett_server['numberOfServers'];
		for($i=0; $i < $this->numberOfServers; $i++){
			$this->servers[$i]['id'] = $muPI_sett_server[1]['serverid'];
			$this->servers[$i]['name'] = $muPI_sett_server[1]['name'];
			$this->servers[$i]['forcemail'] = $muPI_sett_server[1]['forcemail'];
			$this->servers[$i]['authbymail'] = $muPI_sett_server[1]['authbymail'];
			if($this->servers[$i]['authbymail'])
				$this->servers[$i]['forcemail'] = true;
		}
		
	}
	
	function getMainDir(){
		return $this->mainDir;
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
}
?>