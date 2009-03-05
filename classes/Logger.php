<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */

/**
 * Provides logging functionality
 */
class Logger{
	public static function log_loginFail($uname,$pw){
		DBManager::getInstance()->append('log_register', time().';'.$_SERVER['REMOTE_ADDR'].';'.$_SERVER['HTTP_REFERER'].';uname:'.$uname.';pw:'.$pw);
	}
	public static function log_registration($uname){
		DBManager::getInstance()->append('log_register', time().';'.$_SERVER['REMOTE_ADDR'].';'.$_SERVER['HTTP_REFERER'].';uname:'.$uname);
	}
}

?>