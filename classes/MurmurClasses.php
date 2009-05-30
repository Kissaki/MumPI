<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */

class UserRegistration {
	private $playerid;
	private $name;
	private $email;
	private $pw;
	
	function __construct($playerid, $name, $email, $pw){
		$this->playerid = $playerid;
		$this->name = $name;
		$this->email = $email;
		$this->pw = $pw;
	}
	
	function returnTrue(){
		return true;
	}
	
}

interface Server {
		function isRunning();
		function start();
		function stop();
		function delete();
		function id();

		function getConf($key);
		function getAllConf();
		function setConf($key, $value);
		function setSuperuserPassword($password);
		function getLog($intMin, $intMax);

		function getPlayers();
		function getChannels();
		function getTree();

		function getBans();
		function setBans($banlist);

		function kickPlayer($sessionid, $reason);
		function getState($sessionid);
		function setState($player_state);
		function sendMessage($sessionid, $text);
		
		function getChannelState($channelid);
		function setChannelState($channel_state);
		function removeChannel($channelid);
		function addChannel($name, $parentid);
		function sendMessageChannel($channelid, $bool_to_sub_channels, $text);

		function getACL($channelid, $ACLList, $grouplist, $bool_inherit);
		function setACL($channelid, $acllist, $grouplist, $bool_inherit);

		function getPlayerNames($idlist);
		function getPlayerIds($namelist);

		function registerPlayer($name);
		function unregisterPlayer($playerid);
		function updateregistration($registration);
		function getRegistration($playerid);
		function getRegisteredPlayers($filterStr);
		function verifyPassword($name, $pw);
		function getTexture($playerid);
		function setTexture($playerid, $texture);
	
		}


?>
