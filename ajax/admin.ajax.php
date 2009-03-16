<?php
/**
 * Ajax functionality
 * @author Kissaki
 */
//TODO secure this with $_SERVER['HTTP_REFERER']

switch($_GET['ajax']){
	case 'server_create':
		echo ServerInterface::createServer();
}

?>