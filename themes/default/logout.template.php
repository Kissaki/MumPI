<?php
	foreach($_SESSION AS $key=>$value){
		unset($_SESSION[$key]);
	}
?>
<p>You have been logged out.<br/>
<a href="./">Click here</a> to go back to the welcome page.</p>
<script type="text/javascript">location.replace("./")</script>
