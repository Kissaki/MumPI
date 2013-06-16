<?php
require_once(MUMPHPI_MAINDIR.'/classes/HelperFunctions.php');
require_once(MUMPHPI_MAINDIR.'/classes/MessageManager.php');

/**
 * The SettingsManager class is an interface to the settings.
 */
class SettingsManager {
	private static $instance;
	/**
	 * @return SettingsManager
	 */
	public static function getInstance(){	// $obj=NULL){
		if (!isset(self::$instance)) {
			if (!isset($obj)) {
				self::$instance = new SettingsManager();
			} else {
				self::$instance = $obj;
			}
		}
		return self::$instance;
	}

	private $isDebugMode;
	private $mainDir;
	private $mainUrl;
	private $theme;
	private $defaultLanguage;
	private $site;
	private $useCaptcha;
	private $dbType;
	private $showAdminLink;
	private $allowChannelViewerWebservice;
	private $dbInterface_type;
	private $dbInterface_address;
	private $dbInterface_icesecrets;
	private $iceGeneratedMurmurPHPFileName;
	private $numberOfServers;
	private $servers;
	private $serverAddresses;
	private $viewerUseSVGImages;

	function __construct()
	{
		eval(self::getSettingsFileContents());

		$this->isDebugMode = $debug;
		$this->mainDir = MUMPHPI_MAINDIR;
		$this->mainUrl = MUMPHPI_MAINDIR;
		$this->dbInterface_type = $dbInterface_type;
		$this->dbInterface_address = $dbInterface_address;
		$this->dbInterface_icesecrets = $dbInterface_icesecrets;
		$this->iceGeneratedMurmurPHPFileName = isset($iceGeneratedMurmurPHPFileName)?$iceGeneratedMurmurPHPFileName:'Murmur_1.2.2.php';
		$this->theme = $theme;
		$this->defaultLanguage = $defaultLanguage;
		$this->useCaptcha = $useCaptcha;
		$this->dbType = $dbType;
		$this->showAdminLink = $showAdminLink;
		$this->allowChannelViewerWebservice = isset($allowChannelViewerWebservice)?$allowChannelViewerWebservice:true;
		$this->viewerUseSVGImages = isset($viewerUseSVGImages)?$viewerUseSVGImages:false;

		$this->site = array();
		$this->site['title'] = $site_title;
		$this->site['description'] = $site_description;
		$this->site['keywords'] = $site_keywords;

		$this->servers = $servers;

		$this->serverAddresses = $viewer_serverAddresses;

		foreach ($this->servers AS $server) {
			if ($server['authbymail']) {
				$server['forcemail'] = true;
			}
		}
	}

	/**
	 * Get the content of a settings file (opening and closing php tags are stripped)
	 * @return string whole settings file content, without opening and closing php tags are stripped
	 */
	private static function getSettingsFileContents($filename='settings.inc.php')
	{
		// use existant settings file or use default one and save it as a normal settings file
		if (file_exists(MUMPHPI_MAINDIR.'/'.$filename)) {
			$settings = file_get_contents(MUMPHPI_MAINDIR.'/'.$filename);
		} else {
			$settings = file_get_contents(MUMPHPI_MAINDIR.'/settings.inc.default.php');
			// strip php tags
			$settings = str_replace('<?php', '', $settings);
			$settings = str_replace('?>', '', $settings);
			self::setSettingsFileContents($settings);
			$settings = file_get_contents(MUMPHPI_MAINDIR.'/'.$filename);
		}
		// strip php tags
		$settings = substr($settings, 5, strlen($settings)-7);
		return $settings;
	}
	private static function setSettingsFileContents($settings_content, $filename='settings.inc.php')
	{
		// add php tag to settings content
		$settings_content = '<?php' . $settings_content;
		// save file
		file_put_contents(MUMPHPI_MAINDIR.'/'.$filename, $settings_content);
	}
	private static function appendToSettingsFile($append, $filename='settings.inc.php')
	{
		$settings_content = self::getSettingsFileContents($filename);
		$settings_content = '<?php' . $settings_content . "\n" . $append . "\n";
		if (file_exists(MUMPHPI_MAINDIR.'/'.$filename)) {
			file_put_contents(MUMPHPI_MAINDIR.'/'.$filename, $settings_content);
		}
	}

	/**
	 * @return string local main dir of the interface WITHOUT trailing slash
	 */
	function getMainDir()
	{
		return $this->mainDir;
	}
	function getMainUrl()
	{
		return $this->mainUrl;
	}
	/**
	 * @return theme name
	 */
	function getTheme()
	{
		return $this->theme;
	}
	/**
	 *
	 * @return path to theme without trailing slash (theme/ + themename)
	 */
	function getThemePath()
	{
		return 'themes/' . HelperFunctions::getActiveSection() . '/'.$this->theme;
	}
	/**
	 *
	 * @return theme directoy on server filesystem
	 */
	function getThemeDir()
	{
		return $this->mainDir.'/'.$this->getThemePath();
	}
	function getThemeUrl()
	{
		return $this->mainUrl.'/'.$this->getThemePath();
	}
	/**
	 * Get default language
	 * @return string default language (eg: en or de)
	 */
	function getDefaultLanguage()
	{
		return $this->defaultLanguage;
	}
	public function getServerAddress($serverId=null)
	{
		if ($serverId == null) {
			if (strtolower($this->dbInterface_type) === 'ice') {
				$matches;
				preg_match('/-h ([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})/', $this->dbInterface_address, $matches);
				return isset($matches[1])?$matches[1]:null;
			}
		}
		else {
			if (isset($this->serverAddresses[$serverId])) {
				return $this->serverAddresses[$serverId];
			}
			MessageManager::addMessage('Trying to get serveraddress for a serverIp which does not have an associated server address in the settings file.');
		}
		return null;
	}
	function getDbInterfaceType()
	{
		return $this->dbInterface_type;
	}
	function getDbInterface_address()
	{
		return $this->dbInterface_address;
	}
	function getDbInterface_iceSecrets()
	{
		return $this->dbInterface_icesecrets;
	}
	function getIceGeneratedMurmurPHPFileName() {
		return $this->iceGeneratedMurmurPHPFileName;
	}
	function isUseCaptcha()
	{
		return $this->useCaptcha;
	}
	function isShowAdminLink()
	{
		return $this->showAdminLink;
	}
	function isChannelViewerWebserviceAllowed()
	{
		return $this->allowChannelViewerWebservice;
	}
	function getDbType()
	{
		return $this->dbType;
	}
	function getSiteTitle()
	{
		return $this->site['title'];
	}
	function getSiteDescription()
	{
		return $this->site['description'];
	}
	function getSiteKeywords()
	{
		$this->site['keywords'];
	}
	function getNumberOfServers()
	{
		return $this->numberOfServers;
	}
	function getServers()
	{
		return $this->servers;
	}
	function getServerName($serverid)
	{
		if (!isset($this->servers[$serverid])) {
			return null;
		}
		return $this->servers[$serverid]['name'];
	}

	function isForceEmail($serverid)
	{
		return (isset($this->servers[$serverid])?$this->servers[$serverid]['forcemail']:null);
	}
	function isAuthByMail($serverid)
	{
		return (isset($this->servers[$serverid])?$this->servers[$serverid]['authbymail']:null);
	}
	function isDebugMode()
	{
		return $this->isDebugMode;
	}

	function isViewerSVGImagesEnabled() {
		return $this->viewerUseSVGImages;
	}


	/**
	 * Get the Server Information saved about it in the interface DB.
	 * @param $serverid server id
	 * @return unknown_type null if non existant, or a $server array
	 */
	function getServerInformation($serverid)
	{
		if (isset($this->servers[$serverid])) {
			return $this->servers[$serverid];
		}
		return null;
	}
	function setServerInformation($serverid, $name, $allowlogin=true, $allowregistration=true, $forcemail=true, $authbymail=false)
	{
		if (isset($this->servers[$serverid])) {
			// server already has settings; thus update them
			// get and open settings file
			$filename = 'settings.inc.php';
			$filepath = MUMPHPI_MAINDIR.'/'.$filename;
			if (file_exists($filepath)) {
				// get individual lines so we can overwrite them one by one
				$lines = file($filepath);
				$fh = fopen($filepath, 'w');

				// expected string-beginnings in settings file
				$expectedLineBeginning = '$servers[' . $serverid . ']';
				$expectedLineBeginnings = array(
						'name'             =>'$servers['.$serverid.'][\'name\']',
						'allowlogin'       =>'$servers['.$serverid.'][\'allowlogin\']',
						'allowregistration'=>'$servers['.$serverid.'][\'allowregistration\']',
						'forcemail'        =>'$servers['.$serverid.'][\'forcemail\']',
						'authbymail'       =>'$servers['.$serverid.'][\'authbymail\']',
					);

				foreach ($lines AS $line) {
					if (substr($line, 0, strlen($expectedLineBeginning)) == $expectedLineBeginning) {
						// this is our servers settings
						if (strncmp($line, $expectedLineBeginnings['name'], strlen($expectedLineBeginnings['name'])) === 0) {
							fwrite($fh, $expectedLineBeginnings['name'] . '              = \'' . str_replace(array('\\', "'"), array('\\\\', "\'"), $name) . "';\n");
						} else if (strncmp($line, $expectedLineBeginnings['allowlogin'], strlen($expectedLineBeginnings['allowlogin'])) === 0 ) {
							fwrite($fh, $expectedLineBeginnings['allowlogin'] . '        = ' . $allowlogin . ";\n");
						} else if (strncmp($line, $expectedLineBeginnings['allowregistration'], strlen($expectedLineBeginnings['allowregistration'])) === 0 ) {
							fwrite($fh, $expectedLineBeginnings['allowregistration'] . ' = ' . $allowregistration . ";\n");
						} else if (strncmp($line, $expectedLineBeginnings['forcemail'], strlen($expectedLineBeginnings['forcemail'])) === 0 ) {
							fwrite($fh, $expectedLineBeginnings['forcemail'] . '         = ' . $forcemail . ";\n");
						} else if (strncmp($line, $expectedLineBeginnings['authbymail'], strlen($expectedLineBeginnings['authbymail'])) === 0 ) {
							fwrite($fh, $expectedLineBeginnings['authbymail'] . '        = ' . $authbymail . ";\n");
						}
					} else {
						// not our servers settings, just write them untouched
						fwrite($fh, $line);
					}
				}
				fclose($fh);
			}
		} else {
			// There was no server information before, add it to the settings file
			self::appendToSettingsFile(
				 '$servers[' . $serverid . '][\'name\']              = \'' . $name . '\';'."\n"
				.'$servers[' . $serverid . '][\'allowlogin\']        = ' . $allowlogin .        ';'."\n"
				.'$servers[' . $serverid . '][\'allowregistration\'] = ' . $allowregistration . ';'."\n"
				.'$servers[' . $serverid . '][\'forcemail\']         = ' . $forcemail .         ';'."\n"
				.'$servers[' . $serverid . '][\'authbymail\']        = ' . $authbymail .        ';'."\n");
		}
	}
	function removeServerInformation($serverId)
	{
		if (isset($this->servers[$serverId])) {
			// server already has settings

			// get and open settings file
			$filename = 'settings.inc.php';
			$filepath = MUMPHPI_MAINDIR.'/'.$filename;
			if (file_exists($filepath)) {
				// get individual lines so we can overwrite them one by one
				$lines = file($filepath);
				$fh = fopen($filepath, 'w');

				// expected string-beginnings in settings file
				$expectedLineBeginning = '$servers[' . $serverId . ']';

				foreach ($lines AS $line) {
					if (substr($line, 0, strlen($expectedLineBeginning)) == $expectedLineBeginning) {
						// this is our servers settings, so drop them
					} else {
						// not our servers settings, just write them untouched
						fwrite($fh, $line);
					}
				}
				fclose($fh);
			}
		}
		Logger::error('Server with id ' . $serverId . ' was not found in the settings file.');
	}
}
