<?php
/**
 * Permissionmanager for managing permissions,
 * asking for permission…
 */
class PermissionManager
{
	private static $instance;

	/**
	 * Get the object of the PermissionManager, specific to the section
	 * @return PermissionManager_admin
	 */
	public static function getInstance()
	{
		if (self::$instance == null) {
			$section = HelperFunctions::getActiveSection();
			if (class_exists('PermissionManager_' . $section)) {
				eval('self::$instance = new PermissionManager_' . $section . '();');
			} else {
				echo 'Unknown Permission Manager';
			}
		}
		return self::$instance;
	}

}

/**
 * PermissionManager for admin section
 */
class PermissionManager_admin
{
	private $adminGroups;
	private $perms;
	private $servers;
	private $isGlobalAdmin;

	public function __construct()
	{
		if (SessionManager::getInstance()->isAdmin()) {
			$aid = SessionManager::getInstance()->getAdminID();
			$admin = DBManager::getInstance()->getAdmin($aid);
			$this->isGlobalAdmin = $admin['isGlobalAdmin'];
			$this->adminGroups = DBManager::getInstance()->getAdminGroupsByAdminID($aid);
			$this->servers = DBManager::getInstance()->getAdminGroupServersByAdminId($aid);

			$this->perms = array();
			foreach ($this->adminGroups as $group) {
				foreach ($group['adminOnServers'] as $serverId) {
					foreach ($group['perms'] as $perm=>$value) {
						if ($perm!='serverID' && $perm!='groupID') {
							if (!isset($this->perms[$serverId])) {
								$this->perms[$serverId] = array();
							}
							$this->perms[$serverId][$perm] = $value;
						}
					}
				}
			}
		} else {
			$this->isGlobalAdmin = false;
			$this->perms = DBManager::$defaultAdminGroupPerms;
			$this->servers = array();
		}
	}

	/**
	 * Is global admin?
	 * Can administrate all servers, add and remove virtual servers
	 * @return boolean
	 */
	public function isGlobalAdmin()
	{
		return $this->isGlobalAdmin;
	}

	/**
	 * Is the admin an admin of that server?
	 * @param int $serverId
	 * @return bool
	 */
	public function isAdminOfServer($serverId)
	{
		return $this->isGlobalAdmin || in_array($serverId, $this->servers);
	}

	/**
	 * Can start and stop servers?
	 * @param $sid
	 * @return boolean
	 */
	public function serverCanStartStop($sid=null)
	{
		return $this->isGlobalAdmin || ($this->perms[$sid]['startStop'] && in_array($sid, $this->servers));
	}

	/**
	 * Can edit the (virtual) servers (config) settings?
	 * @param $sid
	 * @return boolean
	 */
	public function serverCanEditConf($sid)
	{
		return $this->isGlobalAdmin || ($this->perms[$sid]['editConf'] && in_array($sid, $this->servers));
	}

	/**
	 * Can generate a new superuser password?
	 * @param $sid
	 * @return boolean
	 */
	public function serverCanGenSuUsPW($sid)
	{
		return $this->isGlobalAdmin || ($this->perms[$sid]['genSuUsPW'] && in_array($sid, $this->servers));
	}

	/**
	 * Can view registrations / accounts on the server?
	 * @param $sid
	 * @return boolean
	 */
	public function serverCanViewRegistrations($sid)
	{
		return $this->isGlobalAdmin || ($this->perms[$sid]['viewRegistrations'] && in_array($sid, $this->servers));
	}

	/**
	 * Can edit user accounts?
	 * @param $sid
	 * @return boolean
	 */
	public function serverCanEditRegistrations($sid)
	{
		return $this->isGlobalAdmin || ($this->perms[$sid]['editRegistrations'] && in_array($sid, $this->servers));
	}

	/**
	 * Can create channels, Move users?
	 * @return boolean
	 */
	public function serverCanModerate($sid)
	{
		return $this->isGlobalAdmin || ($this->perms[$sid]['moderate'] && in_array($sid, $this->servers));
	}

	/**
	 * Can kick online users?
	 * @param $sid
	 * @return boolean
	 */
	public function serverCanKick($sid)
	{
		return $this->isGlobalAdmin || ($this->perms[$sid]['kick'] && in_array($sid, $this->servers));
	}

	/**
	 * Can ban users?
	 * @param $sid
	 * @return boolean
	 */
	public function serverCanBan($sid)
	{
		return $this->isGlobalAdmin || ($this->perms[$sid]['ban'] && in_array($sid, $this->servers));
	}

	/**
	 * @return boolean
	 */
	public function serverCanEditChannels($sid)
	{
		return $this->isGlobalAdmin || ($this->perms[$sid]['channels'] && in_array($sid, $this->servers));
	}

	/**
	 * @return boolean
	 */
	public function serverCanEditACLs($sid)
	{
		return $this->isGlobalAdmin || ($this->perms[$sid]['acls'] && in_array($sid, $this->servers));
	}

	/**
	 * @return boolean
	 */
	public function serverCanEditAdmins($sid=null)
	{
		return $this->isGlobalAdmin || (($sid!=null && isset($this->perms[$sid]['admins']))?$this->perms[$sid]['admins']:false);
	}
}
