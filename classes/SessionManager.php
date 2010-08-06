<?php
class SessionManager
{
	private static $instance;

	/**
	 * starts a php session
	 * @return void
	 */
	public static function startSession()
	{
		if (!isset(self::$instance)) {
			self::$instance = new SessionManager_obj();
		}
	}

	/**
	 * @return SessionManager_obj
	 */
	public static function getInstance()
	{
		if (self::$instance == null) {
			self::$instance = new SessionManager_obj();
		}
		return self::$instance;
	}


}

class SessionManager_obj
{
	public function __construct()
	{
		session_start();
	}

	/**
	 * Checks if the visitor is logged in to a mumble user account (on a specific server)
	 * @return boolean
	 */
	public function isUser()
	{
		if (isset($_SESSION['userLoggedIn'])) {
			return true;
		}
		return false;
	}

	/**
	 * Check if the visitor is logged in as an interface admin
	 * @return boolean
	 */
	public function isAdmin()
	{
		if (isset($_SESSION['adminLoggedIn'])) {
			return true;
		}
		return false;
	}

	/**
	 * get language to use
	 * @return string
	 */
	public function getLanguage()
	{
		return isset($_SESSION['language'])?$_SESSION['language']:null;
	}

	/**
	 *
	 * @param string $name
	 * @param string $pw
	 * @return void
	 * @throws Exception on failed login
	 */
	public function loginAsAdmin($name, $pw)
	{
		if (DBManager::getInstance()->checkAdminLogin($_POST['username'], $_POST['password'])) {
			$_SESSION['adminLoggedIn'] = true;
			$admin = DBManager::getInstance()->getAdminByName($name);
			$_SESSION['adminLoggedInAs'] = $admin['id'];
		} else {
			Logger::log("[{$_SERVER['REMOTE_ADDR']}] failed to log in as admin $name.", Logger::LEVEL_SECURITY);
			throw new Exception('Login failed');
		}
	}

	public function adminLogOut()
	{
		unset($_SESSION['adminLoggedIn']);
		unset($_SESSION['adminLoggedInAs']);
	}

	public function getAdminID()
	{
		if (isset($_SESSION['adminLoggedInAs']))
			return $_SESSION['adminLoggedInAs'];
		throw new Exception('Tried to get admin id when not logged in.');
	}

}
