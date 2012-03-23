<?php
	require_once('../classes/SettingsManager.php');
	require_once('../classes/MurmurClasses.php');
	require_once('../classes/ServerInterface.php');

	class ServerViewer
	{
		public static function getHtmlCode4ViewServer($serverId)
		{
			$server = ServerInterface::getInstance()->getServer($serverId);
			if ($server !== null) {
				$server = MurmurServer::fromIceObject($server);
				$tree = $server->getTree();
				return '<div class="server">' . $tree->toHtml() . '</div>';
			}
			return null;
		}
	}
