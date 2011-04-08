<?php

require_once(dirname(__FILE__) . '/MurmurClasses.php');
require_once(dirname(__FILE__) . '/ServerInterface.php');
require_once(dirname(__FILE__) . '/SettingsManager.php');

class ChannelViewerProtocolProducer {

	public function generateJson($serverId)
	{
		$server = ServerInterface::getInstance()->getServer($serverId);
		$tree = $server->getTree();
		$array = array(
			'id' => $server->id(),
			'name' => SettingsManager::getInstance()->getServerName($server->id()),
			'root' => $this->treeToJsonArray($tree),
		);
		return json_encode($array);
	}
	private function treeToJsonArray(Murmur_Tree $tree) {
		$array = array();
		$prior = array();
		$subChannels = $tree->children;
		if (!empty($subChannels)) {
			foreach ($subChannels as $subChannel) {
				$prior[] = $this->treeToJsonArray($subChannel);
			}
		}
		/**
		 * @var Murmur_Channel
		 */
		$chan = $tree->c;
		$array['id'] = $chan->id;
		$array['parent'] = $chan->parent;
		$array['temporary'] = $chan->temporary;
		$array['position'] = $chan->position;
		$array['name'] = $chan->name;
		$array['description'] = $chan->description;
		$array['channels'] = $prior;
		$array['links'] = $chan->links;
		$array['users'] = $this->usersToJsonArray($tree->users, $chan->id);
		return $array;
	}
	private function usersToJsonArray($users, $channelId) {
		$array = array();
    /**
     * @var Murmur_User
     */
    $user = null;
		foreach ($users as $user) {
			$array[] = array(
				'channel' => $channelId,
				'name' => $user->name,
				'deaf' => $user->deaf,
				'mute' => $user->mute,
				'selfDeaf' => $user->selfDeaf,
				'selfMute' => $user->selfMute,
				'session' => $user->session,
				'suppress' => $user->suppress,
				'userid' => $user->userid,
				// following optional fields
				'comment' => $user->comment,
				'idlesecs' => $user->idlesecs,
				'onlinesecs' => $user->onlinesecs,
				'version' => $user->version,
				'release' => $user->release,
				'os' => $user->os,
				'osversion' => $user->osversion,
				'prioritySpeaker' => $user->prioritySpeaker,
				'bytespersec' => $user->bytespersec,
				'tcponly' => $user->tcponly,
				'context' => $user->context,
				'identity' => $user->identity,
			);
		}
		return $array;
	}

	public function generateXml($serverId)
	{
		//TODO implement generateXml
	}
}