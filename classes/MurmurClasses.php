<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */


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
		$name=isset($object[self::USERNAME])?$object[self::USERNAME]:null;
		$email=isset($object[self::USEREMAIL])?$object[self::USEREMAIL]:null;
		$comment=isset($object[self::USERCOMMENT])?$object[self::USERCOMMENT]:null;
		$hash=isset($object[self::USERHASH])?$object[self::USERHASH]:null;
		$password=isset($object[self::USERPASSWORD])?$object[self::USERPASSWORD]:null;
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
	private $bytesPerSec;
	
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
	
	//TODO constructors (from ice obj, new)
	//TODO getters
	//TODO setters
}

/**
 * IPv6 network address
 * 
 * @link http://mumble.sourceforge.net/slice/Murmur.html#NetAddress
 */
class MurmurNetAddress
{
	// TODO implement MurmurNetAddress
}

