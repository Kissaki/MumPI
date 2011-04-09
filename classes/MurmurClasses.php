<?php

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
