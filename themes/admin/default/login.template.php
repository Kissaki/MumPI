<?php
	if (isset($_GET['action']) && $_GET['action']=='dologin') {
		try {
			SessionManager::getInstance()->loginAsAdmin($_POST['username'], $_POST['password']);
			echo '<script type="text/javascript">location.replace("?page=meta")</script>';
			echo 'Login successfull.<br/>
				Go on to the <a href="?page=meta">Meta Page</a>.';
		} catch(Exception $exc) {
			echo 'Login failed.<br/>
				<a href="?page=login">Go back</a> and try again.';
		}
	} else {
?>
<form class="mpi_login_form" action="?page=login&amp;action=dologin" method="post">
	<label for="mpi_login_username">Username</label>
	<input type="text" name="username" id="mpi_login_username" />
	<label for="mpi_login_password">Password</label>
	<input type="password" name="password" id="mpi_login_password" />
	<input type="submit" value="Login" />
</form>
<?php } ?>
