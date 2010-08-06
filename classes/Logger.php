<?php
/**
 * Provides logging functionality
 */
class Logger
{
	const LEVEL_DEBUG='DEBUG';
	const LEVEL_INFO='INFO';
	const LEVEL_ERROR='ERROR';
	const LEVEL_FATAL='FATAL';
	const LEVEL_SECURITY='SECURITY';	// failed logins etc.

	public static function log($message, $level)
	{
		if ($level==self::LEVEL_DEBUG && !SettingsManager::getInstance()->isDebugMode())
			return;
		DBManager::getInstance()->append('log.log', date('Y.m.d H:i:s').' – '.$level.': '.$message);
	}
	public static function debug($message)
	{
		self::log($message, self::LEVEL_DEBUG);
	}
	public static function info($message)
	{
		self::log($message, self::LEVEL_INFO);
	}
	public static function error($message)
	{
		self::log($message, self::LEVEL_ERROR);
	}
	public static function fatal($message)
	{
		self::log($message, self::LEVEL_FATAL);
	}
	public static function log_loginFail($uname,$pw)
	{
		DBManager::getInstance()->append('log_register.log', time().';'.$_SERVER['REMOTE_ADDR'].';'.$_SERVER['HTTP_REFERER'].';uname:'.$uname.';pw:'.$pw);
	}
	public static function log_registration($uname)
	{
		DBManager::getInstance()->append('log_register.log', time().';'.$_SERVER['REMOTE_ADDR'].';'.$_SERVER['HTTP_REFERER'].';uname:'.$uname);
	}
}
