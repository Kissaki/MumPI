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
	
	private $mainDir;
	private $theme;
	private $language;
	private $site;
	
	function __construct(){
		global $muPI_muDir, $muPI_theme, $muPI_lang, $muPI_site;
		
		$this->mainDir = $muPI_muDir;
		$this->theme = $muPI_theme;
		$this->language = $muPI_lang;
		
		$this->site = array();
		$this->site['url'] = $muPI_site['url'];
		$this->site['title'] = $muPI_site['title'];
		$this->site['description'] = $muPI_site['description'];
		$this->site['keywords'] = $muPI_site['keywords'];
		
	}
	
	function getTheme(){
		return $this->theme;
	}
	function getThemePath(){
		return '/themes/'.$this->theme;
	}
	function getThemeDir(){
		return $this->mainDir.$this->getThemePath();
	}
	function getThemeUrl(){
		return $this->siteUrl.getThemePath();
	}
	function getLanguage(){
		return $this->language;
	}
}
?>