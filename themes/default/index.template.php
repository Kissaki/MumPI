
<?php	// TODO: implement login check and remove this php part
	$visitor['loggedIn'] = false; if(isset($_GET['loggedIn'])) $visitor['loggedIn']=$_GET['loggedIn'];
	$visitor['name'] = 'foobar-user';
?>

<div id="topline">
<div id="menu">
	<ul>
		<li><?php echo $txt['home']; ?></li>
		<?php
			if($visitor['loggedIn'])
				echo '<li>'.$txt['login'].'</li><li>'.$txt['register'].'</li>';
			else
				echo '<li>'.$txt['profile'].'</li><li>'.$txt['logout'].'</li>';
		?>
	</ul>
</div>
<?php if($visitor['loggedIn']) echo 'Welcome '.$visitor['name']; 
		else echo 'Welcome. You may want to register and account for a mumble server or log in to change your details.'?>
</div>

