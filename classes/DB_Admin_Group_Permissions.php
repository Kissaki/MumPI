<?php

class DB_Admin_Group_Permissions
{
	//TODO make them private and add (magic) setters and getters, setter would include perm-check
	public $startStop;
	public $editConf;
	public $genSuUsPW;
	public $viewRegistrations;
	public $editRegistrations;
	public $moderate;
	public $kick;
	public $ban;
	public $channels;
	public $acls;
	public $addAdmins;

	public function __construct(bool $startStop, bool $editConf, bool $genSuUsPW, bool $viewRegistrations, bool $editRegistrations, bool $moderate, bool $kick, bool $ban, bool $channels, bool $acls, bool $addAdmins)
	{
		$this->startStop = $startStop;
		$this->editConf = $editConf;
		$this->genSuUsPW = $genSuUsPW;
		$this->viewRegistrations = $viewRegistrations;
		$this->editRegistrations = $editRegistrations;
		$this->moderate = $moderate;
		$this->kick = $kick;
		$this->ban = $ban;
		$this->channels = $channels;
		$this->acls = $acls;
		$this->addAdmins = $admins;
	}

}
