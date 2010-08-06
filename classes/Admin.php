<?php
/**
 * Admin Account
 * TODO: use this class. Better than an array
 */
class Admin
{
	private $id;
	private $name;
	private $pw;
	private $isGlobalAdmin;

	function __construct($id, $name, $pw, $isGlobalAdmin)
	{
		$this->id = intval($id);
		$this->name = $name;
		$this->pw = $pw;
		$this->isGlobalAdmin = (bool)$isGlobalAdmin;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getPasswordHash()
	{
		return $this->pw;
	}

	public function isGlobalAdmin()
	{
		return $isGlobalAdmin;
	}
}
