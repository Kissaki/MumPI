<?php
	define('MUMPHPI_MAINDIR', dirname(__FILE__));

	if (!file_exists('settings.inc.php')) {
		// missing settings file, thus redirect to install
		header('Location: ./install');
	} else if (isset($_GET['view']) && $_GET['view'] == 'json') {
		// channel-viewer protocol http://mumble.sourceforge.net/Channel_Viewer_Protocol
		require_once(dirname(__FILE__) . '/classes/SettingsManager.php');
		// check if it's allowed in settings
		if (!SettingsManager::getInstance()->isChannelViewerWebserviceAllowed()) {
			exit('The settings disallow accessing this webservice.');
		}

		$json = '%s';

		// set content type to JS or JSON
		if (isset($_GET['callback'])) {
      // check for valid callback var
      if (preg_match('/\W/', $_GET['callback'])) {
        // if $_GET['callback'] contains a non-word character, this could be an XSS attack.
        header('HTTP/1.1 400 Bad Request');
        exit();
      } else {
        // if a callback varname is specified, JS is returned
        header('Content-Type: text/javascript; charset=utf-8');
        // … and the json content is assigned to the callback var
        $json = sprintf($json, $_GET['callback'] . '(%s);');
      }
		} else {
			header('Content-Type: application/json');
		}

		// check for serverId and generate corresponding json data
		$serverId = isset($_GET['serverId']) ? intval($_GET['serverId']) : null;
		if (empty($serverId)) {
			$json = sprintf($json, json_encode(array('error'=>'No serverId specified, which is required.')));
		} else {
			$serverId = intval($_GET['serverId']);
			require_once('./classes/ChannelViewerProtocolProducer.php');
			$prod = new ChannelViewerProtocolProducer();
			$json = sprintf($json, $prod->generateJson($serverId));
		}
		// echo JSON data
		echo $json;
	} else {
		// redirect to user section
		header('Location: ./user/');
	}
