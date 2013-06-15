<?php
class MurmurServer
{
	/**
	 * @param Ice_ObjectPrx $iceObject
	 * @return MurmurServer
	 */
	public static function fromIceObject($iceObject)
	{
		if ($iceObject==null) {
			throw new Exception('Required iceObject parameter was null');
		}
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
	public function kickUser($sessionId, $reason='')
	{
		return $this->iceObj->kickUser($sessionId, $reason);
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
		try {
			return MurmurChannel::fromIceObject($this->iceObj->getChannelState(intval($channelId)), $this);
		} catch(MurmurException $e) {
			return 0;
		}
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
	/**
	 * @param $names array(string name) list of names
	 * @return array(string name, int userId) list of name->userId mappings
	 */
	public function getUserIds($names)
	{
		return $this->iceObj->getUserIds();
	}
	/**
	 * @param MurmurUser $user
	 * @return int userId
	 */
	public function registerUser(MurmurUser $user)
	{
		return $this->iceObj->registerUser();
	}
	/**
	 * @param int $userId
	 * @return void
	 */
	public function unregisterUser($userId)
	{
		return $this->iceObj->unregisterUser();
	}
	/**
	 * @param int $registrationId
	 * @param MurmurRegistration $registration
	 * @return void
	 */
	public function updateRegistration($registrationId, MurmurRegistration $registration)
	{
		return $this->iceObj->updateRegistration();
	}
	/**
	 * @param int $registrationId
	 * @return MurmurRegistration
	 */
	public function getRegistration($registrationId)
	{
		$reg = MurmurRegistration::fromIceObject(empty($registrationId)?$this->iceObj->getRegistration():$this->iceObj->getRegistration(intval($registrationId)));
		return $reg;
	}
	/**
	 * @param string $filter
	 * @return array(int registrationIds, string registrationUserName)
	 */
	public function getRegisteredUsers($filter=null)
	{
		return $this->iceObj->getRegisteredUsers($filter);
	}
	/**
	 * @param string $name
	 * @param string $password
	 * @return int userId || -1: failed authentification || -2: unknown username
	 */
	public function verifyPassword($name, $password)
	{
		return $this->iceObj->verifyPassword($name, $password);
	}
	/**
	 * @param int $userId
	 * @return array(int byteNr, int byteValue) image as byteSequence
	 */
	public function getTexture($userId)
	{
		return $this->iceObj->getTexture(intval($userId));
	}
	/**
	 * @param int $userId
	 * @param array $byteSequence
	 * @return void
	 */
	public function setUserAvatar($userId, array $byteSequence)
	{
		$this->iceObj->setTexture(intval($userId), $byteSequence);
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
		if (null!==$this->name)
			$array[self::USERNAME] = $this->name;
		if (null!==$this->email)
			$array[self::USEREMAIL] = $this->email;
		if (null!==$this->comment)
			$array[self::USERCOMMENT] = $this->comment;
		if (null!==$this->hash)
			$array[self::USERHASH] = $this->hash;
		if (null!==$this->password)
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
	 * @var int
	 */
	private $isPrioritySpeaker;

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
															$pluginIdentity, $pluginContext, $comment, MurmurNetAddress $address, $isTcpOnly, $idleSeconds, $isPrioritySpeaker=null)
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
		$this->isPrioritySpeaker = $isPrioritySpeaker;
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
										$iceUser->idlesecs,
										isset($iceUser->prioritySpeaker)?$iceUser->prioritySpeaker:null
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

	/**
	 * @deprecated this was a typo, use getSessionId() instead
	 */
	public function getSessionIds() {
		return $this->sessionId;
	}
	public function getSessionId() {
		return $this->sessionId;
	}
	/**
	 * @return MurmurNetAddress
	 */
	public function getAddress() {
		return $this->address;
	}
	public function getName() {
		return $this->name;
	}

	public function isMuted() {
		return $this->isMuted;
	}
	public function isDeafened() {
		return $this->isDeafened;
	}
	public function isSuppressed() {
		return $this->isSuppressed;
	}
	public function isSelfMuted() {
		return $this->isSelfMuted;
	}
	public function isSelfDeafened() {
		return $this->isSelfDeafened;
	}

	public function getRegistrationId() {
		return $this->registrationId;
	}
	public function getOnlineSeconds() {
		return $this->onlineSeconds;
	}
	public function getBytesPerSecond() {
		return $this->bytesPerSecond;
	}
	public function getClientVersion() {
		return $this->clientVersion;
	}
	public function getClientVersionAsString() {
		return '' . (($this->clientVersion & 0xffff0000) >> 16) . '.' . (($this->clientVersion & 0xff00) >> 8)  . '.' . ($this->clientVersion & 0xff);
	}
	public function getClientRelease() {
		return $this->clientRelease;
	}
	public function getClientOs() {
		return $this->clientOs;
	}
	public function getClientOsVersion() {
		return $this->clientOsVersion;
	}
	public function getPluginIdentity() {
		return $this->pluginIdentity;
	}
	public function getPluginContext() {
		return $this->pluginContext;
	}

	public function getComment() {
		return $this->comment;
	}
	public function isTcpOnly() {
		return $this->isTcpOnly;
	}
	public function getIdleSeconds() {
		return $this->idleSeconds;
	}
	public function isPrioritySpeaker() {
		return $this->isPrioritySpeaker;
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
		for ($byte=0; $byte<count($expected); $byte++) {
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
	/**
	 * @return MurmurTree
	 */
	public function getSubChannels()
	{
		return $this->children;
	}

	/**
	 * @return array(MurmurUser)
	 */
	public function getUsers()
	{
		return $this->users;
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
	private $linkedChannelIds;
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
	public function __construct($id, $name, $parentId, $linkedChannelIds, $description, $isTemporary, $position, &$server)
	{
		$this->id = $id;
		$this->name = $name;
		$this->parentId = $parentId;
		$this->linkedChannelIds = $linkedChannelIds;
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
	/**
	 * @return int
	 */
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
	public function getLinkedChannelIds()
	{
		return $this->linkedChannelIds;
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

class MurmurBan
{
	/**
	 * @param $iceObject
	 * @return MurmurBan
	 */
	public static function fromIceObject($iceObject)
	{
		return new MurmurBan($iceObject->address, $iceObject->bits, $iceObject->name, $iceObject->hash, $iceObject->reason, $iceObject->start, $iceObject->duration);
	}

	public function __construct($address=null, $bits=128, $username='', $hash='', $reason='', $start=0, $duration=0)
  {
	  $this->address = $address;
	  $this->bits = $bits;
	  $this->name = $username;
	  $this->hash = $hash;
	  $this->reason = $reason;
	  $this->start = $start;
	  $this->duration = $duration;
  }

  public $address;
  public $bits;
  public $name;
  public $hash;
  public $reason;
  public $start;
  public $duration;

  public function asJson()
  {
  	return json_encode(array('address'=>$this->address, 'bits'=>$this->bits, 'name'=>$this->name, 'hash'=>$this->hash, 'reason'=>$this->reason, 'start'=>$this->start, 'duration'=>$this->duration));
  }
}
