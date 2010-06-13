<?php
	$isLoggedIn = SessionManager::getInstance()->isAdmin();
	if ($isLoggedIn) {
		echo 'You are already logged in!';
		echo 'Were you looking for <a href="./?page=logout">logout</a>?';
	} else {
		if (isset($_GET['action']) && $_GET['action'] == 'dologin') {
			// parse and handle login form data
			try {
				SessionManager::getInstance()->loginAsAdmin($_POST['username'], $_POST['password']);
				$isLoggedIn = true;
				echo '<script type="text/javascript">location.replace("?page=meta")</script>';
				echo 'Login successfull.<br/>
					Go on to the <a href="?page=meta">Meta Page</a>.';
			} catch(Exception $exc) {
				echo '<div class="infobox infobox_error">Login failed.</div>';
			}
		}
		if (!$isLoggedIn) {
			// display login form
			if (!DBManager::getInstance()->doesAdminExist()) {
				echo '<div class="infobox infobox_info">';
				echo 'No admin Account exists yet.<br/>';
				echo 'To create an account, <b>just log in with your desired login-credentials</b>. The account will automatically created for you!<br/><br/>';
				echo 'If you experience problems and the account is not created for you, please check that your webserver has write permissions to the data folder.';
				echo '</div>';
			}
?>
<form class="mpi_login_form" action="?page=login&amp;action=dologin" method="post" onsubmit="
		if (jQuery('#mpi_login_username').attr('value').length == 0) {alert('You did not enter a username!'); return false;}
		if (jQuery('#mpi_login_password').attr('value').length == 0) {alert('You did not enter a password!'); return false;}">
	<label for="mpi_login_username">Username</label>
	<input type="text" name="username" id="mpi_login_username" />
	<label for="mpi_login_password">Password</label>
	<input type="password" name="password" id="mpi_login_password" />
	<input type="submit" value="Login" />
</form>
<?php
		}
	}
?>
