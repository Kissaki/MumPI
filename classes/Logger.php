<?php
class Logger{
	public static function log_loginFail($uname,$pw){
		DBManager::getInstance()->append('log_register', time().';'.$_SERVER['REMOTE_ADDR'].';'.$_SERVER['HTTP_REFERER'].';uname:'.$uname.';pw:'.$pw);
	}
	public static function log_registration($uname){
		DBManager::getInstance()->append('log_register', time().';'.$_SERVER['REMOTE_ADDR'].';'.$_SERVER['HTTP_REFERER'].';uname:'.$uname);
	}
}
?>