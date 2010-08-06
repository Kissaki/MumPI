<?php
/**
 * The TemplateManager class contains the functionality to work with templates.
 */
class TemplateManager{
	/**
	 * Parse a template. Output will be generated directly.
	 * @param $name The name of the template to use.
	 */
	public static function parseTemplate($name)
	{
		$filepath = SettingsManager::getInstance()->getThemeDir().'/'.$name.'.template.php';
		if (file_exists($filepath)) {
			require_once($filepath);
		} else {
			HelperFunctions::addError('Template file not found when trying to parse template: '.$name);
		}
	}

	public static function getTemplate($name)
	{
		$filepath = SettingsManager::getInstance()->getThemeDir().'/'.$name.'.template.php';
		if (file_exists($filepath)) {
			$template = file_get_contents($filepath);
		} else {
			HelperFunctions::addError('Template file not found when trying to parse template: '.$name);
		}
	}
}
