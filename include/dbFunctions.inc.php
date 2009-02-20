<?php
require_once('../settings.inc.php');

function getDb(){
	global $muPI_dbInterface;
	
	if($muPI_dbInterface == 'ice'){
		if(!extension_loaded('ice')) die('<div class="error"><b>Error</b>: Could not find loaded ice extension.<br/><br/>Please check <a href="http://mumble.sourceforge.net/ICE">the ICE page in the mumble wiki</a> if you don\'t know what to do.</div>');
		return new ServerDatabase_ICE();
	}else{
		die('Misconfiguration: Unknown <acronym title="database">DB</acronym> Interface Type!');
	}
}
?>