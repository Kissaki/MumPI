
<div id="menu">
	<ul>
<?php
		if (!SessionManager::getInstance()->isAdmin()) {
?>
			<li<?php if (HelperFunctions::getActivePage()=='login') echo ' class="active"';?>>
				<a href="./?page=login">Login</a>
			</li>
<?php
		} else {
			HelperFunctions::echoMenuEntry('meta');
			HelperFunctions::echoMenuEntry('server');
			if (PermissionManager::getInstance()->serverCanEditAdmins())
				HelperFunctions::echoMenuEntry('admins');
			HelperFunctions::echoMenuEntry('logout');
?>
		<li style="height:10px; font-size:10px; line-height:10px; margin-top:10px; border-bottom:black;">Back to…</li>
<?php } ?>
		<li><a href="../user/">&lt;-- User</a></li>
	</ul>
</div>
