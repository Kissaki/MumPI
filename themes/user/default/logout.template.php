<div id="content">
	<?php
		unset($_SESSION['serverid']);
		unset($_SESSION['userid']);
		unset($_SESSION['userLoggedIn']);

		echo tr('logout_success');
	?>
	<script type="text/javascript">
		/*<![CDATA[*/
				location.replace("./");
		/*]]>*/
	</script>
</div>