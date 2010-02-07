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
	
	require_once(MUMPHPI_MAINDIR.'/classes/ServerViewer.php');
	
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
		require_once(MUMPHPI_MAINDIR.'/ajax/'.MUMPHPI_SECTION.'.ajax.php');
		if (is_callable('Ajax_'.MUMPHPI_SECTION.'::' . $_GET['ajax']))
			eval('Ajax_'.MUMPHPI_SECTION.'::' . $_GET['ajax'] . '();');
		MessageManager::echoAll();
		exit();
	}
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<title><?php echo SettingsManager::getInstance()->getSiteTitle(); ?></title>
	<meta name="description" content="<?php echo SettingsManager::getInstance()->getSiteDescription(); ?>" />
	<meta name="keywords" content="<?php echo SettingsManager::getInstance()->getSiteKeywords(); ?>" />
	
	<link rel="stylesheet" type="text/css" href="reset-min.css" />
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="../libs/jquery.js"></script>
	<script type="text/javascript">
		var restBase = '<?php echo '../REST/REST.php'; ?>';
		function refreshTree()
		{
			jQuery.post(
					'./?ajax=getServerTreeAsHtml',
					{serverId: 1},
					function(data){
							jQuery('.mumpi_viewer_container_main').html(data);
						}
				);
		}
		jQuery().ready(function(){
				jQuery('.channelname').html('<a>' + jQuery('channelname').html() + '</a>');
				var mumpiViewerRefreshTree = setInterval( "refreshTree()", 1000); // 1000ms=s*
			});
	</script>
</head>
<body>
	<div class="tree_refresh_interval">
		<input type="button" value="stop" title="Do not refresh at all anymore" onclick="clearinterval('mumpiViewerRefreshTree')" />
	</div>
	<div class="mumpi_viewer_container_main"></div>
</body></html>