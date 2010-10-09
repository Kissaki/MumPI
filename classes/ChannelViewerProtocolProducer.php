<?php

require_once(dirname(__FILE__) . '/MurmurClasses.php');
require_once(dirname(__FILE__) . '/ServerInterface.php');
require_once(dirname(__FILE__) . '/SettingsManager.php');

class ChannelViewerProtocolProducer {

	public function generateJson($serverId)
	{
		$server = MurmurServer::fromIceObject(ServerInterface::getInstance()->getServer($serverId));
		$tree = $server->getTree();
		$array = array(
			'id' => $server->getId(),
			'name' => SettingsManager::getInstance()->getServerName($server->getId()),
			'root' => $this->treeToJsonArray($tree),
		);
		return json_encode($array);
	}
	private function treeToJsonArray(MurmurTree $tree) {
		$array = array();
		$prior = array();
		$subChannels = $tree->getSubChannels();
		if (!empty($subChannels)) {
			foreach ($subChannels as $subChannel) {
				$prior[] = $this->treeToJsonArray($subChannel);
			}
		}
		/**
		 * @var MurmurChannel
		 */
		$chan = $tree->getRootChannel();
		$array['id'] = $chan->getId();
		$array['parent'] = $chan->getParentChannelId();
		$array['temporary'] = $chan->isTemporary();
		$array['position'] = $chan->getPosition();
		$array['name'] = $chan->getName();
		$array['description'] = $chan->getDescription();
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