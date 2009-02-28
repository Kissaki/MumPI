<?php
	foreach($_SESSION AS $key=>$value){
		unset($_SESSION[$key]);
	}
	header('Location: ./');
?>
<p>You have been logged out.</p>
