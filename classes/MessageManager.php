<?php
/**
 * Handle Messages that can be polled later, eg at the end of interpreting the page.
 */
class MessageManager
{
	private static $errors = array();
	private static $warnings = array();
	private static $msgs = array();

	public static function error_handler(int $errno, string $errstr, string $errfile=null, int $errline=null, array $errcontext=null)
	{
		self::addError('Error in '.$errfile.' on line '.$errline.":\n(".$errno.'): '.$errstr);
	}
	public static function addError($text)
	{
		self::$errors[] = $text;
		if (SettingsManager::getInstance()->isDebugMode()) echo '<div class="error">[Debug: Error was added] '.$text.'</div>';
	}
	public static function addWarning($text)
	{
		self::$warnings[] = $text;
		if (SettingsManager::getInstance()->isDebugMode()) echo '<div class="warning">[Debug: Warning was added]'.$text.'</div>';
	}
	public static function addMessage($text)
	{
		self::$msgs[] = $text;
	}
	public static function getNumberOfErrors(){
		return count(self::$errors);
	}
	/*
	 * Returns the sum of messages (errors, warnings and messages)
	 */
	public static function getNumberOfMessages(){
		return ( count(self::$errors)+count(self::warnings)+count(self::msgs) );
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
	public static function echoAll(){
		if (count(self::$errors)) {
			echo '<ul class="log_list_errors">';
			MessageManager::echoAllErrors('<li>', '</li>');
			echo '</ul>';
		}
		if (count(self::$warnings)) {
			echo '<ul class="log_list_warnings">';
			MessageManager::echoAllWarnings('<li>', '</li>');
			echo '</ul>';
		}
		if (count(self::$msgs)) {
			echo'<ul class="log_list_messages">';
			MessageManager::echoAllMessages('<li>', '</li>');
			echo '</ul>';
		}
	}
	public static function echoAllErrors($before='', $after='<br />')
	{
		foreach (self::$errors AS $error) {
			echo $before.$error.$after;
		}
	}
	public static function echoAllWarnings($before='', $after='<br />')
	{
		foreach (self::$warnings AS $warning) {
			echo $before.$warning.$after;
		}
	}
	public static function echoAllMessages($before='', $after='<br />')
	{
		foreach (self::$msgs AS $msg) {
			echo $before.$msg.$after;
		}
	}

}
