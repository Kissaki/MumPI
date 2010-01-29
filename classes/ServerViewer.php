<?php
class ServerViewer
{
	public static function getHtmlCode4ViewServer($serverId)
	{
		$server = ServerInterface::getInstance()->getServer($serverId);
		$server = MurmurServer::fromIceObject($server);
		$tree = $server->getTree();
		return $tree->toHtml();
	}
}