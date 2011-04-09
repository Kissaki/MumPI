<?php
class HelperFunctions
{
	public static function getActivePage()
	{
		if (isset($_GET['page'])) {
			return $_GET['page'];
		} else {
			return 'index';
		}

	}
	public static function getActiveSection()
	{
		if (defined('MUMPHPI_SECTION')) {
			return MUMPHPI_SECTION;
		}
		return null;
	}

	public static function getCurrentUrl()
	{
		return $_SERVER['REQUEST_URI'];
	}

	public static function getReferer()
	{
		return $_SERVER['HTTP_REFERER'];
	}
	public static function getVisitorIP()
	{
		return $_SERVER['REMOTE_ADDR'];
	}
	public static function getVisitorHost()
	{
		return $_SERVER['REMOTE_HOST'];
	}

	// This may/probably will be implemented so errors and warnings can be kept until it's time to throw/echo them (in a specific area, eg where the main content area is/should be).
	public static function addError($txt)
	{
		self::echoError($txt);
	}
	public static function addWarning($txt)
	{
		self::echoWarning($txt);
	}
	public static function echoError($txt){
		echo '<div class="error">'.$txt.'</div>';
	}
	public static function echoWarning($txt){
		echo '<div class="warning">'.$txt.'</div>';
	}

	public static function showChannelTree($tree, $level=0)
	{
		$indent = '';
		for ($i=0; $i<$level; $i++) {
			$indent = $indent.'+';
		}
		if (isset($tree->children)) {
			echo $indent.$tree->c->name.'<br/>';
			foreach ($tree->children AS $child) {
				self::showChannelTree($child, $level+1);
			}
		}
	}
	public static function showChannelTreePlayers($tree, $level=0)
	{
		$indent = '';
		for ($i=0; $i<$level; $i++) {
			$indent = $indent.'+';
		}
		echo $indent.$tree->c->name.'<br/>';
		if (count($tree->children)>0) {
			foreach ($tree->children AS $child) {
				self::showChannelTreePlayers($child, $level+1);
			}
		}
		if (count($tree->players)>0) {
			foreach ($tree->players AS $player) {
				echo $indent.$player->name.'<br/>';
			}
		}
	}
	public static function echoMenuEntry($page)
	{
		echo '<li'; if (HelperFunctions::getActivePage()==$page) echo ' class="active"'; echo '><a href="./?page='.$page.'">'. TranslationManager::getText($page) .'</a></li>';
	}
	public static function isValidEmail($mail)
	{
		$mailpattern = '/^([a-z0-9._\-])*\@'
			.  '([a-z0-9])(([a-z0-9_\-])*([a-z0-9]))+'
			.'(\.([a-z0-9_\-])*([a-z0-9])+)+$/i';
		return (preg_match($mailpattern, $mail) > 0);
	}
	public static function getBaseURL()
	{
		return 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['REQUEST_URI']);
	}

	/**
	 * remove newline characters from string
	 * @param $str
	 * @return string
	 */
	public static function stripNewline($str)
	{
		//$str = preg_replace("/\r\n/", '', $str);	// win
		//$str = preg_replace("/\n/", '', $str);		// nix
		//$str = preg_replace("/\r/", '', $str);		// mac
		$str = preg_replace("/\r/", '', $str);
		$str = preg_replace("/\n/", '', $str);
		return $str;
	}

	/**
	 * javascript-alert some text
	 * @param $str text to alert
	 */
	public static function js_alert($str)
	{
		echo '<script type="text/javascript">alert(\'' . $str . '\');</script>';
	}

	public static function print_r_pre($var)
	{
		echo '<pre>';print_r($var);echo'</pre>';
	}
	public static function var_dump_pre($var)
	{
		echo '<pre>';var_dump($var);echo'</pre>';
	}

	public static function ip2int($ip)
	{
		$array = explode('.', $ip);
		$int = 0;

		$byte = count($array)-1;
		foreach ($array as $part) {
			$part = $part << ($byte * 8);
			$int = $int | $part;
			$byte--;
		}
		return $int;
	}
	/**
	 * @param (int_or_array) $int
	 * @throws Exception
	 */
	public static function int2ipAddress($ipAddress)
	{
		$ipAsString = '';
		if (is_int($ipAddress)) {
			//127.0.0.1 = 2130706433 = 0111 1111  0000 0000  0000 0000  0000 0001
			$ipAddress = intval($ipAddress);
			for ($i=0; $i<4; $i++) {
				$ipAsString = '.' . ($ipAddress & 255) . $ipAsString;
				$ipAddress = $ipAddress >> 8;
			}
			$ipAsString = substr($ipAsString, 1);
		}
		else if(is_array($ipAddress)) {
			if (count($ipAddress) == 16) {
				// first check if it’s a mapped IP, so it can be displayed in IPv4 format (::ffff:ipv4asHexBytes1+2:ipv4asHexBytes3+4)
				$mappedIpv4Prefix = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 255, 255);
				$isIp4InIp6 = true;
				foreach ($mappedIpv4Prefix as $i => $val) {
					if ($ipAddress[$i] != $val) {
						$isIp4InIp6 = false;
						break;
					}
				}
				// it’s an IPv4 address in IPv6 address format (mapped address)
				if ($isIp4InIp6) {
					for ($i = 12; $i < 16; $i++) {
						$ipAsString .= $ipAddress[$i];
						if ($i < 15) {
							$ipAsString .= '.';
						}
					}
				}
				// it’s a “normal” IPv6 address
				else {
					for ($i = 0; $i < 16; $i++) {
						$ipAsString = sprintf($ipAsString . '%02x', $ipAddress[$i]);
						if ($i % 2 == 1 && $i < 15) {
							$ipAsString .= ':';
						}
					}
				}
				return $ipAsString;
			}
			else {
				throw new Exception('IP adress array has unexpected length.');
			}
		}
		else {
			throw new Exception('Unknown format as param.');
		}
		return $ip;
	}

	public static function clientVersionToString($v) {
		return '' . (($v & 0xffff0000) >> 16) . '.' . (($v & 0xff00) >> 8)  . '.' . ($v & 0xff);
	}

	public static $IPv4Range = array(
												0=>0,
												1=>0,
												2=>0,
												3=>0,
												4=>0,
												5=>0,
												6=>0,
												7=>0,
												8=>0,
												9=>0,
												10=>0,
												11=>0xffff,
											);
	public static function Murmur_Address_isIPv4($adr)
	{
		for ($byte=0; $byte<count(self::$IPv4Range); $byte++) {
			if (self::$IPv4Range[$byte] !== $adr[$byte]) {
				return false;
			}
		}
		return true;
	}
	public static function Murmur_Address_toString($adr)
	{
		$str = '';
		$tmp = null;
		foreach ($adr AS $byte=>$value) {
			if ($tmp === null)
				$tmp = $value;
			else {
				$str .= sprintf(':%x', $tmp + $value);
				$tmp = null;
			}
		}
		$str = substr($str, 1);
		//TODO: strip 0:, :0: to ::
		return $str;
	}
	public static function Murmur_Address_toIPv4String($adr)
	{
		if (!self::Murmur_Address_isIPv4($adr)) {
			throw new Exception('Not an IPv4 address.');
		}
		$str = '';
		for ($byteNr=count(self::IPv4Range); $byteNr<count($adr); $byteNr++) {
			$str .= '.' . $adr[$byteNr];
		}
		return substr($str, 1);
	}

}
