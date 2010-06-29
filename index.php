<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */

define('MUMPHPI_MAINDIR', dirname(__FILE__));

	if (!file_exists('settings.inc.php')) {
		// missing settings file, thus redirect to install
		header('Location: ./install');
	} else if (isset($_GET['view']) && $_GET['view'] == 'json') {
		// channel-viewer protocol http://mumble.sourceforge.net/Channel_Viewer_Protocol
		$serverId = isset($_GET['serverId']) ? intval($_GET['serverId']) : null;
		if (empty($serverId)) {
			echo 'provide a serverid!';
			exit();
		}
		$serverId = intval($_GET['serverId']);
		require_once('./classes/ChannelViewerProtocolProducer.php');
		header('Content-Type: text/json');
		$prod = new ChannelViewerProtocolProducer();
		$json = $prod->generateJson($serverId);
		if (isset($_GET['callback'])) {
			echo $_GET['callback'] . ' = ';
		}
		echo $json;
	} else {
		// redirect to user section
		header('Location: ./user');
	}
?>