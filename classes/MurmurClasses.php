<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */


class MurmurServer
{
	/**
	 * @param Ice_ObjectPrx $iceObject
	 * @return MurmurServer
	 */
	public static function fromIceObject($iceObject)
	{
		if($iceObject==null)
			throw new Exception('Required iceObject parameter was null');
		return new self($iceObject);
	}
	
	private $iceObj;
	
	public function __construct($iceObj)
	{
		$this->iceObj = $iceObj;
	}
	
	/**
	 * @return bool
	 */
	public function isRunning()
	{
		return $this->iceObj->isRunning();
	}
	public function start()
	{
		return $this->iceObj->start();
	}
	public function stop()
	{
		return $this->iceObj->stop();
	}
	public function delete()
	{
		return $this->iceObj->delete();
	}
	public function getId()
	{
		return $this->iceObj->id();
	}
	public function addCallback(MurmurServerCallback &$callback)
	{
		return $this->iceObj->addCallback($callback);
	}
	public function removeCallback(MurmurServerCallback &$callback)
	{
		return $this->iceObj->removeCallback($callback);
	}
	public function setAuthenticator(MurmurServerAuthenticator &$auth)
	{
		return $this->iceObj->setAuthenticator($auth);
	}
	
	public function getAllConf()
	{
		return $this->iceObj->getAllConf();
	}
	public function getConf($key)
	{
		return $this->iceObj->getConf($key);
	}
	public function setConf($key, $value)
	{
		return $this->iceObj->setConf($key, $value);
	}
	
	public function setSuperuserPassword($newPw)
	{
		return $this->iceObj->setSuperuserPassword($newPw);
	}
	
	/**
	 * @param int $startRowFromEnd Lowest numbered entry to fetch. 0 is the most recent item.
	 * @param int $endRow Last entry to fetch.
	 * @return array array of MurmurLogEntry
	 */
	public function getLog($startRowFromEnd=0, $endRow=100)
	{
		return $this->iceObj->getLog($startRowFromEnd, $endRow);
	}
	
	public function getUsers()
	{
		return $this->iceObj->getUsers();
	}
	/**
	 * @param int $userId
	 * @return MurmurUser
	 */
	public function getUserById($userId)
	{
		$userMap = $this->iceObj->getUsers();
		$user = isset($userMap[$userId])?MurmurUser::fromIceObject($userMap[$userId]):null;
		return $user;
	}
	public function getChannels()
	{
		return $this->iceObj->getChannels();
	}
	/**
	 * @return MurmurTree
	 * @throws Murmur_ServerBootedException
	 */
	public function getTree()
	{
		return MurmurTree::fromIceObject($this->iceObj->getTree(), $this);
	}
	public function getBans()
	{
		return $this->iceObj->getBans();
	}
	public function setBans()
	{
		return $this->iceObj->setBans();
	}
	public function kickUser()
	{
		return $this->iceObj->kickUser();
	}
	public function getState()
	{
		return $this->iceObj->getState();
	}
	public function setState()
	{
		return $this->iceObj->setState();
	}
	public function sendMessage()
	{
		return $this->iceObj->sendMessage();
	}
	public function hasPermission()
	{
		return $this->iceObj->hasPermission();
	}
	public function addContextCallback()
	{
		return $this->iceObj->addContextCallback();
	}
	public function removeContextCallback()
	{
		return $this->iceObj->removeContextCallback();
	}
	/**
	 * same as getChannel
	 * !obsolete!
	 * @return MurmurChannel
	 */
	public function getChannelState($channelId)
	{
		return $this->getChannel($channelId);
	}
	/**
	 * @param $channelId
	 * @return MurmurChannel
	 */
	public function getChannel($channelId)
	{
		return MurmurChannel::fromIceObject($this->iceObj->getChannelState(intval($channelId)), $this);
	}
	public function setChannelState()
	{
		return $this->iceObj->setChannelState();
	}
	public function removeChannel()
	{
		return $this->iceObj->removeChannel();
	}
	public function addChannel()
	{
		return $this->iceObj->addChannel();
	}
	public function sendMessageChannel()
	{
		return $this->iceObj->sendMessageChannel();
	}
	public function getACL()
	{
		return $this->iceObj->getACL();
	}
	public function setACL()
	{
		return $this->iceObj->setACL();
	}
	public function addUserToGroup()
	{
		return $this->iceObj->addUserToGroup();
	}
	public function removeUserFromGroup()
	{
		return $this->iceObj->removeUserFromGroup();
	}
	public function redirectWhisperGroup()
	{
		return $this->iceObj->redirectWhisperGroup();
	}
	public function getUserNames()
	{
		return $this->iceObj->getUserNames();
	}
	public function getUserIds()
	{
		return $this->iceObj->getUserIds();
	}
	public function registerUser()
	{
		return $this->iceObj->registerUser();
	}
	public function unregisterUser()
	{
		return $this->iceObj->unregisterUser();
	}
	public function updateRegistration()
	{
		return $this->iceObj->updateRegistration();
	}
	public function getRegistration($registrationId)
	{
		$reg = MurmurRegistration::fromIceObject(empty($registrationId)?$this->iceObj->getRegistration():$this->iceObj->getRegistration(intval($registrationId)));
		return $reg;
	}
	public function getRegisteredUsers()
	{
		return $this->iceObj->getRegisteredUsers();
	}
	public function verifyPassword()
	{
		return $this->iceObj->verifyPassword();
	}
	public function getTexture()
	{
		return $this->iceObj->getTexture();
	}
	public function setTexture()
	{
		return $this->iceObj->setTexture();
	}
	
	//TODO clean this, also using parent chans would suck - make it JS instead…
	public function getJoinUrl()
	{
		$info = SettingsManager::getInstance()->getServerInformation($this->getId());
		$host = $info['host'];
		if (empty($host))
			return '.';
		$port = $this->getConf('port');
		$port = (!empty($port))?$port:'64738';
		return 'mumble://' . $host . ':' . $port;
	}
}

/**
 * a registration on a virtual server
 * 
 * slice doc name: UserInfo
 * @link http://mumble.sourceforge.net/slice/Murmur/UserInfo.html
 */
class MurmurRegistration
{
	// constants – slice definition: enum UserInfo { UserName, UserEmail, UserComment, UserHash, UserPassword };
	const USERNAME=0;
	const USEREMAIL=1;
	const USERCOMMENT=2;
	const USERHASH=3;
	const USERPASSWORD=4;
	
	private $serverId;
	private $name;
	private $email;
	private $comment;
	private $hash;
	private $password;
	
	public function __construct($serverId, $userId, $name, $email=null, $comment=null, $hash=null, $password=null)
	{
		$this->serverId=$serverId;
		$this->userId=$userId;
		$this->name=$name;
		$this->email=$email;
		$this->comment=$comment;
		$this->hash=$hash;
		$this->password=$password;
	}
	
	/**
	 * create a MurmurRegistration object from ice object/array UserInfoMap
	 * @param unknown_type $object UserInfoMap
	 * @return MurmurRegistration
	 */
	public static function fromIceObject(array $object, $serverId, $userId)
	{
		$name     = isset($object[self::USERNAME])    ?$object[self::USERNAME]    :null;
		$email    = isset($object[self::USEREMAIL])   ?$object[self::USEREMAIL]   :null;
		$comment  = isset($object[self::USERCOMMENT]) ?$object[self::USERCOMMENT] :null;
		$hash     = isset($object[self::USERHASH])    ?$object[self::USERHASH]    :null;
		$password = isset($object[self::USERPASSWORD])?$object[self::USERPASSWORD]:null;
		return new self($serverId, $userId, $name, $email, $comment, $hash, $password);
	}
	/**
	 * @return array with name, email, comment, hash, password and indices defined as constants
	 */
	public function toArray()
	{
		$array = array();
		if(null!==$this->name)
			$array[self::USERNAME] = $this->name;
		if(null!==$this->email)
			$array[self::USEREMAIL] = $this->email;
		if(null!==$this->comment)
			$array[self::USERCOMMENT] = $this->comment;
		if(null!==$this->hash)
			$array[self::USERHASH] = $this->hash;
		if(null!==$this->password)
			$array[self::USERPASSWORD] = $this->password;
		return $array;
		
		/* the following would be much easier, but will send the null values which are then saved as empty strings
		return array(
			self::USERNAME=>$this->name,
			self::USEREMAIL=>$this->email,
			self::USERCOMMENT=>$this->comment,
			self::USERHASH=>$this->hash,
			self::USERPASSWORD=>$this->password,
			);*/
	}
	
	// getters
	public function getServerId()
	{
		return $this->serverId;
	}
	public function getUserId()
	{
		return $this->userId;
	}
	public function getName()
	{
		return $this->name;
	}
	public function getEmail()
	{
		return $this->email;
	}
	public function getComment()
	{
		return $this->comment;
	}
	public function getHash()
	{
		return $this->hash;
	}
	public function getPassword()
	{
		return $this->password;
	}
	
	// setters
	public function setName($name)
	{
		$this->name = $name;
	}
	public function setEmail($email)
	{
		$this->email=$email;
	}
	public function setComment($comment)
	{
		$this->comment=$comment;
	}
	public function setHash($hash)
	{
		$this->hash=$hash;
	}
	public function setPassword($password)
	{
		$this->password=$password;
	}
}


/**
 * a currently connected User (on a virtual server)
 * 
 * slice doc name: User
 * @link http://mumble.sourceforge.net/slice/Murmur/User.html
 */
class MurmurUser
{
	/**
	 * @var int
	 */
	private $sessionId;
	/**
	 * -1 if anonymous
	 * @var int
	 */
	private $registrationId;
	
	private $isMuted;
	private $isDeafened;
	private $isSuppressed;
	private $isSelfMuted;
	private $isSelfDeafened;
	
	/**
	 * @var int
	 */
	private $channelId;
	
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var int
	 */
	private $onlineSeconds;
	/**
	 * @var int
	 */
	private $bytesPerSecond;
	
	/**
	 * @var int 16 upper bits is major, followed by 8 bits of minor version, followed by 8 bits of patchlevel => 0x00010203 is 1.2.3
	 */
	private $clientVersion;
	/**
	 * @var string for releases: version, for snapshots/compiles: something else
	 */
	private $clientRelease;
	/**
	 * @var string
	 */
	private $clientOs;
	/**
	 * @var string
	 */
	private $clientOsVersion;
	
	/**
	 * @var string unique ID inside current game
	 */
	private $pluginIdentity;
	/**
	 * @var string binary blob, game and team…
	 */
	private $pluginContext;
	
	/**
	 * @var string
	 */
	private $comment;
	/**
	 * @var MurmurNetAddress byte sequence, ipv6 address
	 */
	private $address;
	/**
	 * @var bool
	 */
	private $isTcpOnly;
	/**
	 * @var int
	 */
	private $idleSeconds;
	
	/**
	 * @param int $sessionId
	 * @param int $registrationId
	 * @param bool $isMuted
	 * @param bool $isDeafened
	 * @param bool $isSuppressed
	 * @param bool $isSelfMuted
	 * @param bool $isSelfDeafened
	 * @param int $channelId
	 * @param unknown_type $name
	 * @param int $onlineSeconds
	 * @param int $bytesPerSec
	 * @param int $clientVersion
	 * @param string $clientRelease
	 * @param string $clientOs
	 * @param string $clientOsVersion
	 * @param string $pluginIdentity
	 * @param string $pluginContext
	 * @param string $comment
	 * @param int $address
	 * @param bool $isTcpOnly
	 * @param int $idleSeconds
	 * @return MurmurUser
	 */
	public function __construct($sessionId, $registrationId, $isMuted, $isDeafened, $isSuppressed, $isSelfMuted, $isSelfDeafened,
															$channelId, $name, $onlineSeconds, $bytesPerSecond, $clientVersion, $clientRelease, $clientOs, $clientOsVersion,
															$pluginIdentity, $pluginContext, $comment, MurmurNetAddress $address, $isTcpOnly, $idleSeconds)
	{
		$this->sessionId=$sessionId;
		$this->registrationId=$registrationId;
		$this->isMuted=$isMuted;
		$this->isDeafened=$isDeafened;
		$this->isSuppressed=$isSuppressed;
		$this->isSelfMuted=$isSelfMuted;
		$this->isSelfDeafened=$isSelfDeafened;
		$this->channelId=$channelId;
		$this->name=$name;
		$this->onlineSeconds=$onlineSeconds;
		$this->bytesPerSecond=$bytesPerSecond;
		$this->clientVersion=$clientVersion;
		$this->clientRelease=$clientRelease;
		$this->clientOs=$clientOs;
		$this->clientOsVersion=$clientOsVersion;
		$this->pluginIdentity=$pluginIdentity;
		$this->pluginContext=$pluginContext;
		$this->comment=$comment;
		$this->address=$address;
		$this->isTcpOnly=$isTcpOnly;
		$this->idleSeconds=$idleSeconds;
	}
	/**
	 * Create a MurmurUser from an ice User
	 * @param Murmur_User $iceUser
	 * @return MurmurUser
	 */
	public static function fromIceObject(Murmur_User $iceUser)
	{
		return new self(
										$iceUser->session,
										$iceUser->userid,
										$iceUser->mute,
										$iceUser->deaf,
										$iceUser->suppress,
										$iceUser->selfMute,
										$iceUser->selfDeaf,
										$iceUser->channel,
										$iceUser->name,
										$iceUser->onlinesecs,
										$iceUser->bytespersec,
										$iceUser->version,
										$iceUser->release,
										$iceUser->os,
										$iceUser->osversion,
										$iceUser->identity,
										$iceUser->context,
										$iceUser->comment,
										MurmurNetAddress::fromIceObject($iceUser->address),
										$iceUser->tcponly,
										$iceUser->idlesecs
									);
	}
	
	public function __toString()
	{
		return $this->toString();
	}
	public function toString()
	{
		return $this->getName();
	}
	public function toHtml()
	{
		return '<div class="username">' . $this->getName() . '</div>';
	}
	
	//TODO getters
	/**
	 * dynamic getter for vars
	 * @param string $name varname
	 * @return unknown_type
	 */
	public function __get($name)
	{
		if (isset($this->$name)) {
			return $this->$name;
		}
	}
	/**
	 * dynamic getter for get fns
	 * @param string $name fnname
	 * @param array $arguments fn arguments
	 * @return unknown_type
	 */
	public function __call($name, array $arguments)
	{
		if (substr($name, 0, 3)=='get') {
			$varName = strtolower(substr($name, 3, 1)).substr($name, 4);
			return $this->$varName;
		}
	}
	
	public function getSessionIds()
	{
		return $this->sessionId;
	}
	/**
	 * @return MurmurNetAddress
	 */
	public function getAddress()
	{
		return $this->address;
	}
	public function getName()
	{
		return $this->name;
	}
	
	//TODO setters
}

/**
 * IPv6 network address
 * 
 * @link http://mumble.sourceforge.net/slice/Murmur.html#NetAddress
 */
class MurmurNetAddress
{
	private $IPv4Range;
	private $address;

	public static function fromIceObject(array $address)
	{
		// $byte: byte number (0-15); $value: int
		foreach ($address AS $byte=>$value) {
			
		}
		return new self($address);
	}
	public function __construct(array $address)
	{
		$this->address = $address;
		$this->IPv4Range = array(
											0=>0,
											1=>0,
											2=>0,
											3=>0,
											4=>0,
											5=>0,
											6=>0,
											7=>0,
											8=>0,
											9=>0,
											10=>0,
											11=>0xffff,
											);
	}
	
	public function isIPv4()
	{
		// IPv4 range
		$expected = $this->IPv4Range;
		for($byte=0; $byte<count($expected); $byte++) {
			if ($expected[$byte] !== $this->address[$byte]) {
				return false;
			}
		}
		return true;
	}
	public function isIPv6()
	{
		return !$this->isIPv4();
	}
	public function __toString()
	{
		$str = '';
		$tmp = null;
		foreach ($this->address AS $byte=>$value) {
			if ($tmp === null)
				$tmp = $value;
			else {
				$str .= sprintf(':%x', $tmp + $value);
				$tmp = null;
			}
		}
		$str = substr($str, 1);
		//TODO: strip 0:, :0: to ::
		return $str;
	}
	public function toString()
	{
		return $this->__toString();
	}
	public function toStringAsIPv4()
	{
		if (!$this->isIPv4())
			throw new Exception('Not an IPv4 address.');
		$str = '';
		for ($byteNr=count($this->IPv4Range); $byteNr<count($this->address); $byteNr++) {
			$str .= '.' . $this->address[$byteNr];
		}
		return substr($str, 1);
	}
}

class MurmurTree
{
	/**
	 * @param unknown_type $iceObject
	 * @param MurmurServer $server
	 * @return MurmurTree
	 */
	public static function fromIceObject($iceObject, &$server)
	{
		// get current channel
		$channel = MurmurChannel::fromIceObject($iceObject->c, $server);
		// get child channels
		$children = array();
		foreach ($iceObject->children as $child) {
			$children[] = self::fromIceObject($child, $server);
		}
		// get users in channel
		$users = array();
		foreach ($iceObject->users as $user) {
			$users[] = MurmurUser::fromIceObject($user);
		}
		// return new instance of the tree
		return new self($channel, $children, $users);
	}
	
	private $channel;
	private $children;
	private $users;
	
	/**
	 * @param MurmurChannel $channel
	 * @param array $children
	 * @param array $users
	 * @return MurmurTree
	 */
	public function __construct($channel, $children, $users)
	{
		/**
		 * @var MurmurChannel
		 */
		$this->channel = $channel;
		/**
		 * @var array array of MurmurTree
		 */
		$this->children = $children;
		/**
		 * @var array array of MurmurTree
		 */
		$this->users = $users;
	}
	
	public function toHtml()
	{
		$html = '<div class="channel">';
		$html .=   '<div class="channelname">' . $this->channel->getName() . '</div>';
		if (!empty($this->children)) {
			$html .=   '<ul class="subchannels">';
			foreach ($this->children as $child) {
				$html .=   '<li>' . $child->toHtml() . '</li>';
			}
			$html .=   '</ul>';
		}
		if (!empty($this->users)) {
			$html .=   '<ul class="users">';
			foreach ($this->users as $user) {
				$html .=   '<li>'. $user->toHtml() . '</li>';
			}
			$html .=   '</ul>';
		}
		$html .= '</div>';
		
		return $html;
	}
	public function toString()
	{
		//TODO line prefix for increasing indent
		$str = (string)$this->channel . "\n";
		foreach ($this->children as $child) {
			$str .= '+ ' . (string)$child . "\n";
		}
		foreach ($this->users as $user) {
			$str .= '* ' . (string)$user . "\n";
		}
		return $str;
	}
	public function __toString()
	{
		return $this->toString();
	}
	
	/**
	 * @return MurmurChannel
	 */
	public function getRootChannel()
	{
		return $this->channel;
	}
	public function getSubChannels()
	{
		return $this->children;
	}
}

class MurmurChannel
{
	/**
	 * @param unknown_type $iceObject
	 * @return MurmurChannel
	 */
	public static function fromIceObject($iceObject, &$server)
	{
		return new self($iceObject->id, $iceObject->name, $iceObject->parent, $iceObject->links, $iceObject->description, $iceObject->temporary, $iceObject->position, $server);
	}
	
	/**
	 * @var MurmurServer
	 */
	private $server;
	/**
	 * @var int
	 */
	private $id;
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var int
	 */
	private $parentId;
	/**
	 * @var array of int
	 */
	private $linkedChannels;
	/**
	 * @var string
	 */
	private $description;
	/**
	 * @var bool
	 */
	private $isTemporary;
	/**
	 * @var int
	 */
	private $position;
	
	/**
	 * @param int $id
	 * @param string $name
	 * @param int $parent id of the parent channel, or -1 on root
	 * @param array $links array of int linked channel ids
	 * @param string $description
	 * @param bool $isTemporary
	 * @param int $position
	 * @return MurmurChannel
	 */
	public function __construct($id, $name, $parentId, $linkedChannels, $description, $isTemporary, $position, &$server)
	{
		$this->id = $id;
		$this->name = $name;
		$this->parentId = $parentId;
		$this->linkedChannels = $linkedChannels;
		$this->description = $description;
		$this->isTemporary = $isTemporary;
		$this->position = $position;
		$this->server = $server;
	}
	
	public function __toString()
	{
		return $this->toString();
	}
	public function toString()
	{
		return $this->getName();
	}
	
	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}
	/**
	 * @return string channel name
	 */
	public function getName()
	{
		return $this->name;
	}
	public function getParentChannelId()
	{
		return $this->parentId;
	}
	public function getDescription()
	{
		return $this->description;
	}
	public function getPosition()
	{
		return $this->position;
	}
	public function isTemporary()
	{
		return $this->isTemporary;
	}
	
	/**
	 * Get the mumble:// join url
	 * @return string
	 */
	public function getJoinUrl()
	{
		//TODO this probably also requires the parent chan, right?
		return $this->server->getJoinUrl() . '/' . $this->getName();
	}
}


