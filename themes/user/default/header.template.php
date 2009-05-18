
<div id="topline">
<div id="menu">
	<ul>
		<li><a href="./"><?php echo tr('home'); ?></a></li><?php
			if(!isset($_SESSION['userid']))
				echo '<li><a href="./?page=login">'.tr('login').'</a></li>'.
					'<li><a href="./?page=register">'.tr('register').'</a></li>';
			else
				echo '<li><a href="./?page=profile">'.tr('profile').'</a></li>'.
					'<li><a href="./?page=logout">'.tr('logout').'</a></li>';
		?>
	</ul>
</div>
<?php
	if(isset($_SESSION['userid']))
		printf( tr('welcome_user'), ServerInterface::getInstance()->getUserName($_SESSION['serverid'],$_SESSION['userid']) ); 
	else
		echo tr('welcome_guest');
?>
</div>
