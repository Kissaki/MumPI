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
		echo '<li'; if(HelperFunctions::getActivePage()=='$page') echo ' class="active"'; echo '><a href="./?page='.$page.'">'. TranslationManager::getText($page) .'</a></li>';
	}
	
	
}
?>