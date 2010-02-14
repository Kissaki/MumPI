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
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/jquery.eztip.js"></script>
	<script type="text/javascript" src="../js/jquery.ba-bbq.min.js"></script>
	<script type="text/javascript" src="../js/mumpi.js"></script>
	<script type="text/javascript">
		var mumpiSetting_viewerDefaultRefreshInterval = 20; // seconds
		var mumpiSetting_viewerServerId = <?php echo isset($_GET['serverId'])?intval($_GET['serverId']):1; ?>;
		
		var mumpiViewerRefreshTreeRunning = false;
		var mumpiViewerRefreshTreeObject;
		var mumpiViewerRefreshTreeRate;

		function refreshTree()
		{
			showAjaxLoading();
			jQuery.post(
					'./?ajax=getServerTreeAsHtml',
					{serverId: mumpiSetting_viewerServerId},
					function(data){
							jQuery('.mumpi_viewer_container_main').html(data);
							hideAjaxLoading();
						}
				);
		}
		function refreshTreeIntervalStart()
		{
			refreshTree();
			mumpiViewerRefreshTreeRunning = true;
			mumpiViewerRefreshTreeObject = setInterval( "refreshTree();", mumpiViewerRefreshTreeRate);
			jQuery('.mumpi_viewer_tree_refresh_action').attr('value', 'Stop Auto-Refresh');
		}
		function refreshTreeIntervalStop()
		{
			clearInterval(mumpiViewerRefreshTreeObject);
			mumpiViewerRefreshTreeRunning = false;
			jQuery('.mumpi_viewer_tree_refresh_action').attr('value', 'Start Auto-Refresh');
		}
		function refreshTreeIntervalToggle()
		{
			if (mumpiViewerRefreshTreeRunning)
				refreshTreeIntervalStop();
			else
				refreshTreeIntervalStart();
		}
		function setTreeRefreshIntervalValue(value)
		{
			mumpiViewerRefreshTreeRate=value;
			jQuery('.mumpi_viewer_tree_refresh_interval_value').attr('value', mumpiViewerRefreshTreeRate/1000);
			jQuery('.mumpi_viewer_tree_refresh_interval_value_unit').html('s');
			if (mumpiViewerRefreshTreeRunning) {
				refreshTreeIntervalStop();
				refreshTreeIntervalStart();
			}
		}

		// document ready -> INITIALIZATION
		jQuery(document).ready(function(){
				jQuery('.mumpi_viewer_tree_refresh_interval_value').change(function(){setTreeRefreshIntervalValue(jQuery(this).attr('value')*1000);});
				setTreeRefreshIntervalValue(mumpiSetting_viewerDefaultRefreshInterval*1000);
				refreshTreeIntervalStart();

				jQuery('.mumpi_viewer_tree_refresh_action').click(function(){
						refreshTreeIntervalToggle();
					});

				// add icon to external links
				jQuery('a').filter(function(){
				    return this.hostname && this.hostname !== location.hostname;
				  }).after(' <img src="../img/external.png" alt="[external]"/>');
			  // tooltips
				jQuery(document).eztip('.mumpi_tooltip', {contentAttrs:['title', 'href']});
			});
	</script>
</head>
<body>
	<div class="tree_refresh_interval">
		Refreshing all: <input class="mumpi_viewer_tree_refresh_interval_value" type="text" size="2" value="?"/><span class="mumpi_viewer_tree_refresh_interval_value_unit"></span><br/>
		<input class="mumpi_viewer_tree_refresh_action" type="button" value="stop" title="Do not refresh at all anymore" />
		<span class="mumpi_ajax_status"></span>
	</div>
	<div class="mumpi_viewer_container_main"></div>
</body></html>