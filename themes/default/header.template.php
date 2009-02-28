
<div id="topline">
<div id="menu">
	<ul>
		<li><a href="./"><?php echo TranslationManager::getInstance()->getText('home'); ?></a></li><?php
			if(!isset($_SESSION['userid']))
				echo '<li><a href="./?section=login">'.TranslationManager::getInstance()->getText('login').'</a></li>'.
					'<li><a href="./?section=register">'.TranslationManager::getInstance()->getText('register').'</a></li>';
			else
				echo '<li><a href="./?section=profile">'.TranslationManager::getInstance()->getText('profile').'</a></li>'.
					'<li><a href="./?section=logout">'.TranslationManager::getInstance()->getText('logout').'</a></li>';
		?>
	</ul>
</div>
<?php
	if(isset($_SESSION['userid']))
		echo 'Welcome '.ServerDatabase::getInstance()->getUserName($_SESSION['serverid'],$_SESSION['userid']); 
	else
		echo 'Welcome. You may want to register and account for a mumble server or log in to change your details.'?>
</div>
