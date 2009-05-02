<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */

/**
 * Handle Messages that can be polled later, eg at the end of interpreting the page.
 */
class MessageManager
{
	private static $errors = array();
	private static $warnings = array();
	private static $msgs = array();
	
	public static function addError($text)
	{
		self::$errors[] = $text;
		if(SettingsManager::getInstance()->isDebugMode()) echo '<div class="error">'.$text.'</div>';
	}
	public static function addWarning($text)
	{
		self::$warnings[] = $text;
	}
	public static function addMessage($text)
	{
		self::$msgs[] = $text;
	}
	
	public static function getErrors()
	{
		return self::$errors;
	}
	public static function getWarnings()
	{
		return self::$warnings;
	}
	public static function getMessages()
	{
		return self::$msgs;
	}
	
}
?>