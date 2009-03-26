<div id="content">
<?php
	unset($_SESSION['serverid']);
	unset($_SESSION['userid']);
	unset($_SESSION['userLoggedIn']);
?>
	<?php TranslationManager::echoText('logout_success'); ?>
	<script type="text/javascript">location.replace("./")</script>
</div>