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

	/**
	 * (multibyte) character to Unicode codepoint value
	 */
	public static function codepointDec($char)
	{
		$size = strlen($char);
		$ordinal = ord($char[0]) & (0xFF >> $size);
		for($i = 1; $i < $size; $i++){
			$ordinal = $ordinal << 6 | (ord($char[$i]) & 127);
		}
		return $ordinal;
	}

	public static function unicodeCodepointOfMBChar($char)
	{
		$hex = codepointHex($char);
		return 'U+' . substr('0000' . strtoupper($hex), min(-4, -1 * strlen($hex)));
	}

	public static function codepointHex($char)
	{
		return dechex(codepointDec($char));
	}

	/**
	 * While this is not a complete fix (e.g. Ä is not handled as expected),
	 * this method does order testa before testA before testb before testB (rather than testA testB testa testb).
	 */
	public static function naturalOrderCompare($a, $b)
	{
		// I guess this is always the case?
		$ENCODING = 'UTF-8';
		$len = min(mb_strlen($a, $ENCODING), mb_strlen($b, $ENCODING));
		mb_regex_encoding($ENCODING);

		$aa = array();
		$i = 0;
		if (mb_ereg_search_init($a, '.', 'suX') === TRUE)
		{
			while ($i < $len && ($res = mb_ereg_search_regs()) !== FALSE)
			{
				if (count($res) !== 1)
				{
					exit('WTF why is the count != 1');
				}
				$aa[] = $res[0];
				$i++;
			}
		}

		$i = 0;
		if (mb_ereg_search_init($b, '.', 'suX') === TRUE)
		{
			while (($res = mb_ereg_search_regs()) !== FALSE)
			{
				if (count($res) !== 1)
				{
					exit('WTF why is the count != 1');
				}
				
				$aaa = $aa[$i];
				$bbb = $res[0];
				if ($bbb !== $aaa && mb_strtolower($aaa) === mb_strtolower($bbb))
				{
					return self::codepointDec($bbb) - self::codepointDec($aaa);
				}
				$i++;
			}
		}
		return strnatcmp($a, $b);
	}
}
