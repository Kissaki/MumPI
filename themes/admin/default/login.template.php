<?php
	if(isset($_GET['action']) && $_GET['action']=='dologin'){
		if(DBManager::getInstance()->checkAdminLogin($_POST['username'], $_POST['password'])){
			$_SESSION['adminLoggedIn'] = true;
			echo '<script type="text/javascript">location.replace("?page=meta")</script>';
			echo 'Login successfull.<br/>
				Go on to the <a href="?page=meta">Meta Page</a>.';
		}else{
			echo 'Login failed.<br/>
				<a href="?page=login">Go back</a> and try again.';
		}
	}else{
?>
<form action="?page=login&amp;action=dologin" method="post">
	<input type="text" name="username" />
	<input type="password" name="password" />
	<input type="submit" value="Login" />
</form>
<?php } ?>
