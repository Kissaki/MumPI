<?php

class Ajax
{
	public static function checkParameters(array $params)
	{
		foreach ($params as $name) {
			if (!isset($_POST[$name])) {
				self::returnErrorMissingParameter($name);
			}
		}
	}
	public static function returnErrorMissingParameter($name)
	{
		echo 'Missing parameter ' . $name;
		exit();
	}
}
