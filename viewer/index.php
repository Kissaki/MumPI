<?php
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

	if (SettingsManager::getInstance()->isDebugMode())
		error_reporting(E_ALL);

	// Check for running Ice with Murmur
	try {
		ServerInterface::getInstance();
	} catch(Ice_UnknownLocalException $ex) {
		MessageManager::addError(tr('error_noIce'));
		MessageManager::echoAll();
		exit();
  }

	if (isset($_GET['ajax'])) {
		require_once(MUMPHPI_MAINDIR.'/ajax/'.MUMPHPI_SECTION.'.ajax.php');
		if (is_callable('Ajax_'.MUMPHPI_SECTION.'::' . $_GET['ajax']))
			eval('Ajax_'.MUMPHPI_SECTION.'::' . $_GET['ajax'] . '();');
		MessageManager::echoAll();
		exit();
	}

	$serverId = isset($_GET['serverId'])?intval($_GET['serverId']):1;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />

	<title><?php echo SettingsManager::getInstance()->getSiteTitle(); ?></title>
	<meta name="description" content="<?php echo SettingsManager::getInstance()->getSiteDescription(); ?>" />
	<meta name="keywords" content="<?php echo SettingsManager::getInstance()->getSiteKeywords(); ?>" />
	<meta name="generator" content="MumPI by KCode" />
	<meta name="author" content="KCode.de" />

	<link rel="stylesheet" type="text/css" href="reset-min.css" />
	<link rel="stylesheet" type="text/css" href="style.css" />
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/jquery.eztip.js"></script>
	<script type="text/javascript" src="../js/jquery.ba-bbq.min.js"></script>
	<script type="text/javascript" src="../js/mumpi.js"></script>
	<script type="text/javascript">/*<![CDATA[*/
		var mumpiSetting_viewerDefaultRefreshInterval = 20; // seconds
		var mumpiSetting_viewerServerId = <?php echo $serverId; ?>;
		var mumpiSetting_viewerServerIp = '<?php echo SettingsManager::getInstance()->getServerAddress($serverId); ?>';
		if (mumpiSetting_viewerServerIp == '') {
		  mumpiSetting_viewerServerIp = null;
		}
		var mumpiSetting_viewerServerVersion = '<?php $a = explode(' ', ServerInterface::getInstance()->getVersion(), 2); echo $a[0]; ?>';

		var mumpiViewerRefreshTreeRunning = false;
		var mumpiViewerRefreshTreeObject;
		var mumpiViewerRefreshTreeRate;
		<?php $rootName = MurmurServer::fromIceObject(ServerInterface::getInstance()->getServer($serverId))->getConf('registername'); ?>
		var mumpiViewerRootName = '<?php echo ( !empty($rootName)?htmlspecialchars($rootName):'Root' ); ?>';

		// create chan and user images as dom objects (for faster draw, especially SVG)
	  <?php
		  $chanImgUrl = SettingsManager::getInstance()->getMainUrl() . '/img/mumble/channel_12.png';
			$chanImgHtmlObj = '<img src="' . $chanImgUrl . '" alt=""/>';
			if (SettingsManager::getInstance()->isViewerSVGImagesEnabled()) {
				$chanImgUrl = SettingsManager::getInstance()->getMainUrl() . '/img/mumble/channel.svg';
				$chanImgHtmlObj = '<object data="' . $chanImgUrl . '" type="image/svg+xml" width="12" height="12">' . $chanImgHtmlObj . '</object>';
			}
			$userImgUrl = SettingsManager::getInstance()->getMainUrl() . '/img/mumble/talking_off_12.png';
			$userImgHtmlObj = '<img src="' . $userImgUrl . '" alt=""/>';
			if (SettingsManager::getInstance()->isViewerSVGImagesEnabled()) {
				$userImgUrl = SettingsManager::getInstance()->getMainUrl() . '/img/mumble/talking_off.svg';
				$userImgHtmlObj = '<object data="' . $userImgUrl . '" type="image/svg+xml" width="12" height="12">' . $userImgHtmlObj . '</object>';
			}
		?>
		var mumpiChanImgHtmlObj = jQuery('<?php echo $chanImgHtmlObj; ?>');
		var mumpiUserImgHtmlObj = jQuery('<?php echo $userImgHtmlObj; ?>');

		function refreshTree()
		{
			showAjaxLoading();
			jQuery.post(
					'./?ajax=getServerTreeAsHtml',
					{serverId: mumpiSetting_viewerServerId},
					function(data){
							jQuery('.mumpi_viewer_container_main').html(data);
							// rename root channel to servers registername, if set
							jQuery('.channelname:first').html(mumpiViewerRootName);
							// link channels if a target server ip is set
							if (mumpiSetting_viewerServerIp != null) {
								linkChannels();
							}
							hideAjaxLoading();
						  // add chan and user icons
					  	jQuery('.channelname').prepend(mumpiChanImgHtmlObj);
					  	jQuery('.username').prepend(mumpiUserImgHtmlObj);
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
		function linkChannels(channel, urlPart, rootChannel)
		{
			if (rootChannel == null) {
				rootChannel = false;
			}
			if (channel == null) {
				jQuery('.server > .channel').each(function(index) {
						linkChannels(jQuery(this), 'mumble://' + mumpiSetting_viewerServerIp + '/', true);
					});
			} else {
				if (channel.hasClass('channel')) {
					var channelName = channel.children('.channelname');
					if (channelName) {
						var channelUrlPart = null;
						if (rootChannel) {
							channelUrlPart = urlPart;
						} else {
							channelUrlPart = urlPart + channelName.text() + '/';
						}
						channelName.wrapInner('<a href="' + channelUrlPart + '?version=' + mumpiSetting_viewerServerVersion + '"/>');
						channel.children('.subchannels').children('li').children('.channel').each(function(index) {
								linkChannels(jQuery(this), channelUrlPart);
							});
					}
				}
			}
		}

		// document ready -> INITIALIZATION
		jQuery(document).ready(function(){
				jQuery('.mumpi_viewer_tree_refresh_interval_value')
					.change(
						function() {
							setTreeRefreshIntervalValue(jQuery(this).attr('value')*1000);
						}
					);
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
		/*]]>*/
	</script>
</head>
<body>
	<div class="tree_refresh_interval">
		Refreshing all: <input class="mumpi_viewer_tree_refresh_interval_value" type="text" size="2" value="?"/><span class="mumpi_viewer_tree_refresh_interval_value_unit">s</span><br/>
		<input class="mumpi_viewer_tree_refresh_action" type="button" value="stop" title="Do not refresh at all anymore" />
		<button onclick="refreshTree();" title="manual refresh"><img src="../img/refresh_16.png" alt="♺" style="height:16px;"/></button>
		<span class="mumpi_ajax_status"></span>
	</div>
	<div class="mumpi_viewer_container_main"></div>
</body></html>