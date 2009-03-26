<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */

/**
 * The TemplateManager class contains the functionality to work with templates.
 */
class TemplateManager{
	/**
	 * Parse a template. Output will be generated directly.
	 * @param $name The name of the template to use.
	 */
	public static function parseTemplate($name){
		$filepath = SettingsManager::getInstance()->getThemeDir().'/'.$name.'.template.php';
		if(file_exists($filepath)){
			require_once($filepath);
		}else{
			HelperFunctions::addError('Template file not found when trying to parse template: '.$name);
		}
	}
}


?>