<?php
	define('MUMPHPI_MAINDIR', '..');
	define('MUMPHPI_SECTION', 'user');

	// Start timer for execution time of script first
	require_once(MUMPHPI_MAINDIR.'/classes/PHPStats.php');
	PHPStats::scriptExecTimeStart();

	require_once(MUMPHPI_MAINDIR.'/classes/MessageManager.php');
	require_once(MUMPHPI_MAINDIR.'/classes/SettingsManager.php');
	require_once(MUMPHPI_MAINDIR.'/classes/DBManager.php');
	require_once(MUMPHPI_MAINDIR.'/classes/Logger.php');
	require_once(MUMPHPI_MAINDIR.'/classes/SessionManager.php');
	SessionManager::startSession();
	require_once(MUMPHPI_MAINDIR.'/classes/TranslationManager.php');
	require_once(MUMPHPI_MAINDIR.'/classes/ServerInterface.php');
	require_once(MUMPHPI_MAINDIR.'/classes/HelperFunctions.php');
	require_once(MUMPHPI_MAINDIR.'/classes/TemplateManager.php');

	if (SettingsManager::getInstance()->isDebugMode()) {
		error_reporting(E_ALL);
	}

	// Check for running Ice with Murmur
	try {
		ServerInterface::getInstance();
	} catch(Ice_UnknownLocalException $ex) {
		MessageManager::addError(tr('error_noIce'));
		MessageManager::echoAll();
		exit();
	}

	if (isset($_GET['ajax'])) {
		require_once(MUMPHPI_MAINDIR.'/ajax/user.ajax.php');
		die();
	}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<title><?php echo SettingsManager::getInstance()->getSiteTitle(); ?></title>
	<meta name="description" content="<?php echo SettingsManager::getInstance()->getSiteDescription(); ?>" />
	<meta name="keywords" content="<?php echo SettingsManager::getInstance()->getSiteKeywords(); ?>" />
	<meta name="generator" content="MumPI by KCode" />
	<meta name="author" content="KCode.de" />

	<?php TemplateManager::parseTemplate('HTMLHead');; ?>
</head>
<body>

<?php
	if (isset($_GET['page'])) {
		switch ($_GET['page']) {
			case 'register':
				$pageSection = 'register';
				break;

			case 'login':
				$pageSection = 'login';
				break;

			case 'logout':
				// Check that visitor is logged in
				if (isset($_SESSION['userid'])) {
					$pageSection = 'logout';
				} else {	// not logged in -> send to index
					header('Location: ./');
					echo '<script type="text/javascript">location.replace("./")</script>';
					echo 'Successfull logout.<br/>go <a href="./">here</a>';
					$pageSection = 'index';
				}
				break;

			case 'profile':
				// Check that visitor is logged in
				if (isset($_SESSION['userid'])) {
					$pageSection = 'profile';
				} else {	// not logged in -> send to index
					header('Location: ./');
					echo '<script type="text/javascript">location.replace("./")</script>';
					echo 'Not logged in.<br/>go <a href="./">here</a>';
					$pageSection = 'index';
				}
				break;

			case 'request':
				$pageSection = 'request';
				break;

			default:
				$pageSection = 'index';
		}
	} else {
		$pageSection = 'index';
	}

	// Parse Template
	TemplateManager::parseTemplate('header');
	TemplateManager::parseTemplate($pageSection);
	TemplateManager::parseTemplate('footer');

?>
</body></html>