<div id="content">
<?php
	foreach($_SESSION AS $key=>$value){
		unset($_SESSION[$key]);
	}
?>
	<?php TranslationManager::echoText('logout_success'); ?>
	<script type="text/javascript">location.replace("./")</script>
</div>