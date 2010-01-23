<?php
class HelperFunctions{
	public static function getActivePage(){
		if(isset($_GET['page'])){
			return $_GET['page'];
		}else{
			return 'index';
		}
		
	}
	public static function getActiveSection(){
		if(defined('MUMPHPI_SECTION')){
			return MUMPHPI_SECTION;
		}
		return null;
	}
	
	public static function getCurrentUrl(){
		return $_SERVER['REQUEST_URI'];
	}
	
	public static function getReferer(){
		return $_SERVER['HTTP_REFERER'];
	}
	public static function getVisitorIP(){
		return $_SERVER['REMOTE_ADDR'];
	}
	public static function getVisitorHost(){
		return $_SERVER['REMOTE_HOST'];
	}
	
	// This may/probably will be implemented so errors and warnings can be kept until it's time to throw/echo them (in a specific area, eg where the main content area is/should be).
	public static function addError($txt){
		self::echoError($txt);
	}
	public static function addWarning($txt){
		self::echoWarning($txt);
	}
	public static function echoError($txt){
		echo '<div class="error">'.$txt.'</div>';
	}
	public static function echoWarning($txt){
		echo '<div class="warning">'.$txt.'</div>';
	}
	
	public static function showChannelTree($tree, $level=0){
		$indent = '';
		for($i=0; $i<$level; $i++){
			$indent = $indent.'+';
		}
		if(isset($tree->children)){
			echo $indent.$tree->c->name.'<br/>';
			foreach($tree->children AS $child){
				self::showChannelTree($child, $level+1);
			}
		}
	}
	public static function showChannelTreePlayers($tree, $level=0){
		$indent = '';
		for($i=0; $i<$level; $i++){
			$indent = $indent.'+';
		}
		echo $indent.$tree->c->name.'<br/>';
		if(count($tree->children)>0){
			foreach($tree->children AS $child){
				self::showChannelTreePlayers($child, $level+1);
			}
		}
		if(count($tree->players)>0){
			foreach($tree->players AS $player){
				echo $indent.$player->name.'<br/>';
			}
		}
	}
	public static function echoMenuEntry($page){
		echo '<li'; if(HelperFunctions::getActivePage()==$page) echo ' class="active"'; echo '><a href="./?page='.$page.'">'. TranslationManager::getText($page) .'</a></li>';
	}
	public static function isValidEmail($mail)
	{
		$mailpattern = '/^([a-z0-9._\-])*\@'
			.  '([a-z0-9])(([a-z0-9_\-])*([a-z0-9]))+'
			.'(\.([a-z0-9_\-])*([a-z0-9])+)+$/i';
		if( preg_match($mailpattern, $mail) > 0 )
			return true;
		return false;
	}
	public static function getBaseURL(){
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
	public static function int2ip($int)
	{
		//127.0.0.1 = 2130706433 = 0111 1111  0000 0000  0000 0000  0000 0001
		$int = intval($int);
		$ip = '';
		for ($i=0; $i<4; $i++) {
			$ip = '.' . ($int & 255) . $ip;
			$int = $int >> 8;
		}
		$ip = substr($ip, 1);
		
		return $ip;
	}
	
	
}
?>