<?php

require_once(dirname(__FILE__) . '/MurmurClasses.php');
require_once(dirname(__FILE__) . '/ServerInterface.php');
require_once(dirname(__FILE__) . '/SettingsManager.php');

class ChannelViewerProtocolProducer {

	public function generateJson($serverId)
	{
		$serverIce = ServerInterface::getInstance()->getServer($serverId);
		if ($serverIce == null) {
		return json_encode(array());
		}
		$server = MurmurServer::fromIceObject(ServerInterface::getInstance()->getServer($serverId));
		$tree = $server->getTree();
		$connecturlTemplate = 'mumble://' . urlencode(SettingsManager::getInstance()->getServerAddress($server->getId())) . '%s?version=1.2.0';
		$array = array(
			'id' => $server->getId(),
			'name' => SettingsManager::getInstance()->getServerName($server->getId()),
			// Remove the template placeholder. The server connect URL is complete here. 
			'x_connecturl' => sprintf($connecturlTemplate, ''),
			'root' => $this->treeToJsonArray($tree, $connecturlTemplate),
		);
		return json_encode($array);
	}
	private function treeToJsonArray(MurmurTree $tree, $connecturlTemplate=null) {
		/**
		 * @var MurmurChannel
		 */
		$chan = $tree->getRootChannel();
		if ($connecturlTemplate != null && $chan->getParentChannelId() != -1)
		{
			$connecturlTemplate = sprintf($connecturlTemplate, '/' . urlencode($chan->getName()) . '%s');
		}

		$array = array();
		$prior = array();
		$subChannels = $tree->getSubChannels();
		if (!empty($subChannels)) {
			foreach ($subChannels as $subChannel) {
				$prior[] = $this->treeToJsonArray($subChannel, $connecturlTemplate);
			}
		}

		$array['id'] = $chan->getId();
		$array['parent'] = $chan->getParentChannelId();
		$array['temporary'] = $chan->isTemporary();
		$array['position'] = $chan->getPosition();
		$array['name'] = $chan->getName();
		$array['description'] = $chan->getDescription();
		if ($connecturlTemplate != null)
		{
			// Remove template placeholder. The URL is complete here.
			$array['x_connecturl'] = sprintf($connecturlTemplate, '');
		}
		$array['channels'] = $prior;
		$array['links'] = $chan->getLinkedChannelIds();
		$array['users'] = $this->usersToJsonArray($tree->getUsers(), $chan->getId());
		return $array;
	}
	private function usersToJsonArray($users, $channelId) {
		$array = array();
		foreach ($users as $user) {
			$array[] = array(
				'channel' => $channelId,
				'name' => $user->getName(),
				'deaf' => $user->isDeafened(),
				'mute' => $user->isMuted(),
				'selfDeaf' => $user->isSelfDeafened(),
				'selfMute' => $user->isSelfMuted(),
				'session' => $user->getSessionId(),
				'suppress' => $user->isSuppressed(),
				'userid' => $user->getRegistrationId(),
				// following optional fields
				'comment' => $user->getComment(),
				'idlesecs' => $user->getIdleSeconds(),
				'onlinesecs' => $user->getOnlineSeconds(),
				'version' => $user->getClientVersion(),
				'release' => $user->getClientRelease(),
				'os' => $user->getClientOs(),
				'osversion' => $user->getClientOsVersion(),
				'prioritySpeaker' => $user->isPrioritySpeaker(),
				'bytespersec' => $user->getBytesPerSecond(),
				'tcponly' => $user->isTcpOnly(),
				'context' => $user->getPluginContext(),
				'identity' => $user->getPluginIdentity(),
			);
		}
		return $array;
	}

	public function generateXml($serverId)
	{
		//TODO implement generateXml
	}
}