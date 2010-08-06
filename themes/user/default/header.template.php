<div id="topline">
<div id="menu">
	<ul>
		<?php
			function echoMenuEntry($link, $textIndex)
			{
				echo '<li><a href="'.$link.'">'.tr($textIndex).'</a></li>';
			}

			echoMenuEntry('./', 'home');
			if (!SessionManager::getInstance()->isUser()) {
				echoMenuEntry('./?page=login', 'login');
				echoMenuEntry('./?page=register', 'register');
			} else {
				echoMenuEntry('./?page=profile', 'profile');
				echoMenuEntry('./?page=logout', 'logout');
			}
			if (SettingsManager::getInstance()->isShowAdminLink()) {
				echoMenuEntry('../admin/', 'admin_area');
			}
		?>
	</ul>
</div>
<?php
	if (isset($_SESSION['userid'])) {
		printf( tr('welcome_user'), ServerInterface::getInstance()->getUserName($_SESSION['serverid'],$_SESSION['userid']) );
	} else {
		echo tr('welcome_guest');
	}
?>
</div>
