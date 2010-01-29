<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */

define('MUMPHPI_MAINDIR', '..');
define('MUMPHPI_SECTION', 'viewer');

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
	
	if(SettingsManager::getInstance()->isDebugMode())
		error_reporting(E_ALL);
	
	// Check for running Ice with Murmur
	try{
		ServerInterface::getInstance();
	}catch(Ice_UnknownLocalException $ex) {
		MessageManager::addError(tr('error_noIce'));
		MessageManager::echoAll();
		exit();
  	}
	
	if(isset($_GET['ajax'])){
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
	
</head>
<body>

<?php
	require_once(MUMPHPI_MAINDIR.'/classes/ServerViewer.php');
	
	// Parse Template
	echo ServerViewer::getHtmlCode4ViewServer(1);
	echo ServerViewer::getHtmlCode4ViewServer(2);
	
?>
</body></html>