<?php
class PHPStats
{
	private static $scriptExecutionTimeStart;

	public  static function scriptExecTimeStart()
	{
		if (!isset(self::$scriptExecutionTimeStart)) {
			self::$scriptExecutionTimeStart = microtime(true);
		}
	}
	public  static function scriptExecTimeGet()
	{
		return (microtime(true) - self::$scriptExecutionTimeStart);
	}
}
