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
	 * Get the content of a settings file (opening and closing php tags are stripped)
	 * @return string whole settings file content, without opening and closing php tags are stripped
	 */
	private static function getSettingsFileContents($filename=null)
	{
		if($filename==null)
			$filename = 'settings.inc.php';
		
		if(file_exists(MUMPHPI_MAINDIR.'/'.$filename)){
			$settings = file_get_contents(MUMPHPI_MAINDIR.'/'.$filename);
		}else{
			$settings = file_get_contents(MUMPHPI_MAINDIR.'/settings.inc.default.php');
			self::setSettingsFileContents($settings);
		}
		$settings = substr($settings, 5, strlen($settings)-7);	// strip php tags;
		return $settings;
		
	}
	private static function setSettingsFileContents($settings_content, $filename=null)
	{
		if($filename==null)
			$filename = 'settings.inc.php';
		
		$settings_content = '<?php'.$settings_content.'?>';
		
		file_put_contents(MUMPHPI_MAINDIR.'/'.$filename, $settings_content);
	}
	private static function appendToSettingsFile($append, $filename=null)
	{
		if($filename==null)
			$filename = 'settings.inc.php';
		
		$settings_content = self::getSettingsFileContents($filename);
		$settings_content = '<?php'.$settings_content.$append."\n".'?>';
		if(file_exists(MUMPHPI_MAINDIR.'/'.$filename)){
			file_put_contents(MUMPHPI_MAINDIR.'/'.$filename, $settings_content);
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
	
	
	/**
	 * Get the Server Information saved about it in the interface DB.
	 * @param $serverid server id
	 * @return unknown_type null if non existant, or a $server array
	 */
	function getServerInformation($serverid)
	{
		if(isset($this->servers[$serverid]))
		{
			return $this->servers[$serverid];
		}
		return null;
	}
	function setServerInformation($serverid, $name, $allowlogin=true, $allowregistration=true, $forcemail=true, $authbymail=false)
	{
		if(isset($this->servers[$serverid]))
		{
			$filename = 'settings.inc.php';
			$filepath = MUMPHPI_MAINDIR.'/'.$filename;
			if(file_exists($filepath)){
				$lines = file($filepath);
				$fh = fopen($filepath, 'w');
				foreach($lines AS $line)
				{
					if( substr($line, 0, 11) == '$servers['.$serverid.']')
					{
						if( strncmp($line, '$servers['.$serverid.'][\'name\']', 19) === 0 )
						{
							fwrite($fh, '$servers['.$serverid.'][\'name\']              = \''.$name.'\';'."\n");
						}
						if( strncmp($line, '$servers['.$serverid.'][\'allowlogin\']', 25) === 0 )
						{
							fwrite($fh, '$servers['.$serverid.'][\'allowlogin\']        = '.$allowlogin.';'."\n");
						}
						if( strncmp($line, '$servers['.$serverid.'][\'allowregistration\']', 32) === 0 )
						{
							fwrite($fh, '$servers['.$serverid.'][\'allowregistration\'] = '.$allowregistration.';'."\n");
						}
						if( strncmp($line, '$servers['.$serverid.'][\'forcemail\']', 24) === 0 )
						{
							fwrite($fh, '$servers['.$serverid.'][\'forcemail\']         = '.$forcemail.';'."\n");
						}
						if( strncmp($line, '$servers['.$serverid.'][\'authbymail\']', 25) === 0 )
						{
							fwrite($fh, '$servers['.$serverid.'][\'authbymail\']        = '.$authbymail.';'."\n");
						}
					}else{
						fwrite($fh, $line);
					}
				}
				fclose($fh);
			}
			
//			$settings = str_replace( '$servers['.$serverid.'][\'name\']              = \''.$this->servers[$serverid]['name'].'\';',
//				'$servers['.$serverid.'][\'name\']              = \''.$name.'\';',
//				$settings);
//			$settings = str_replace( '$servers['.$serverid.'][\'allowlogin\']        = '.$this->servers[$serverid]['allowlogin'].';',
//				'$servers['.$serverid.'][\'allowlogin\']        = '.$allowlogin.';',
//				$settings);
			
			//$settings = self::getSettingsFileContents();
			//ereg_replace('$servers\['.$serverid.'\]\[\'name\'\]              = \'(.*)\';', '$servers\['.$serverid.'\][\'name\']              = \''.$name.'\';', $settings);
			//self::setSettingsFileContents($settings);
		}else{	// There was no server information before, add it to the settings file
			self::appendToSettingsFile(
				 '$servers['.$serverid.'][\'name\']              = \''.$name.'\';'."\n"
				.'$servers['.$serverid.'][\'allowlogin\']        = '.$allowlogin.';'."\n"
				.'$servers['.$serverid.'][\'allowregistration\'] = '.$allowregistration.';'."\n"
				.'$servers['.$serverid.'][\'forcemail\']         = '.$forcemail.';'."\n"
				.'$servers['.$serverid.'][\'authbymail\']        = '.$authbymail.';'."\n");
		}
	}
}
?>