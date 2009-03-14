
<div id="topline">
<div id="menu">
	<ul>
		<li><a href="./"><?php echo TranslationManager::getText('home'); ?></a></li><?php
			if(!isset($_SESSION['userid']))
				echo '<li><a href="./?page=login">'.TranslationManager::getText('login').'</a></li>'.
					'<li><a href="./?page=register">'.TranslationManager::getText('register').'</a></li>';
			else
				echo '<li><a href="./?page=profile">'.TranslationManager::getText('profile').'</a></li>'.
					'<li><a href="./?page=logout">'.TranslationManager::getText('logout').'</a></li>';
		?>
	</ul>
</div>
<?php
	if(isset($_SESSION['userid']))
		echo 'Welcome '.ServerInterface::getInstance()->getUserName($_SESSION['serverid'],$_SESSION['userid']); 
	else
		echo 'Welcome. You may want to register and account for a mumble server or log in to change your details.'?>
</div>
