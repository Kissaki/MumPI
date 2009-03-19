<?php
/**
 * Ajax functionality
 * @author Kissaki
 */
//TODO secure this with $_SERVER['HTTP_REFERER']
//TODO secure this, preferably session data

switch($_GET['ajax']){
	case 'getPage':
		TemplateManager::parseTemplate($_GET['page']);
		break;
		
	case 'server_create':
		echo ServerInterface::getInstance()->createServer();
		break;
	case 'server_start':
		ServerInterface::getInstance()->startServer($_POST['sid']);
		break;
	case 'server_stop':
		ServerInterface::getInstance()->stopServer($_POST['sid']);
		break;
		
	case 'server_getRegistrations':
		$users = array();
		try{
			$users = ServerInterface::getInstance()->getServerRegistrations($_POST['sid']);
		}catch(Murmur_ServerBootedException $exc){
			echo '<div class="error">Server is not running</div>';
			break;
		}
		echo '<div class="jqWindow">';
		echo '<ul>';
		foreach($users AS $user){
			echo '<li>'.$user->name.'</li>';
		}
		echo '</ul>';
		echo '</div>';
		break;
}

?>