<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */

/**
 * Permissionmanager for managing permissions,
 * asking for permission…
 */
class PermissionManager
{
	private static $instance;
	
	/**
	 * Get the object of the PermissionManager, specific to the section
	 * @return object
	 */
	public static function getInstance()
	{
		if(self::$instance == null){
			$secion = HelperFunctions::getActiveSection();
			if (class_exists('PermissionManager_' . $section)) {
				eval('self::$instance = new PermissionManager_' . $section . '();');
			} else {
				// TODO: transl
				// TODO: errormsg
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
	private $isGlobalAdmin;
	
	public function __construct()
	{
		if (SessionManager::getInstance()->isAdmin()) {
			
		} else {
			$this->isGlobalAdmin = false;
		}
	}
	
	/**
	 * Is global admin?
	 * Can administrate all servers, add and remove virtual servers
	 * @return bool
	 */
	public function isGlobalAdmin()
	{
		$admin = DBManager::getInstance()->getAdmin($_SESSION['adminLoggedInAs']);
		if ($admin['isGlobalAdmin'] === true) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Can start and stop servers?
	 * @param $sid
	 * @return unknown_type
	 */
	public function serverCanStartStop($sid)
	{
		// TODO: IMPLEMENT
	}
	
	/**
	 * Can edit the (virtual) servers (config) settings?
	 * @param $sid
	 * @return unknown_type
	 */
	public function serverCanEditConf($sid)
	{
		// TODO: IMPLEMENT
	}
	
	/**
	 * Can generate a new superuser password?
	 * @param $sid
	 * @return unknown_type
	 */
	public function serverCanGenSuUsPW($sid)
	{
		// TODO: IMPLEMENT
	}
	
	/**
	 * Can view registrations / accounts on the server?
	 * @param $sid
	 * @return unknown_type
	 */
	public function serverCanViewRegistrations($sid)
	{
		// TODO: IMPLEMENT
	}
	
	/**
	 * Can edit user accounts?
	 * @param $sid
	 * @return unknown_type
	 */
	public function serverCanEditRegistrations($sid)
	{
		// TODO: IMPLEMENT
	}
	
	/**
	 * Can create channels, Move users?
	 * @return bool
	 */
	public function serverCanModerate($sid)
	{
		// TODO: IMPLEMENT
	}
	
	/**
	 * Can kick online users?
	 * @param $sid
	 * @return unknown_type
	 */
	public function serverCanKick($sid)
	{
		// TODO: IMPLEMENT
	}
	
	/**
	 * Can ban users?
	 * @param $sid
	 * @return unknown_type
	 */
	public function serverCanBan($sid)
	{
		// TODO: IMPLEMENT
	}
}

?>