
<div id="topline">
<div id="menu">
	<ul>
		<li><a href="./" title="<?php echo $txt['home']; ?>"><?php echo $txt['home']; ?></a></li><?php
			if(!$visitor['loggedIn'])
				echo '<li><a href="./?section=login">'.$txt['login'].'</a></li><li><a href="./?section=register">'.$txt['register'].'</a></li>';
			else
				echo '<li><a href="./?section=profile">'.$txt['profile'].'</a></li><li><a href="./?section=logout">'.$txt['logout'].'</a></li>';
		?>
	</ul>
</div>
<?php if($visitor['loggedIn']) echo 'Welcome '.$visitor['name']; 
		else echo 'Welcome. You may want to register and account for a mumble server or log in to change your details.'?>
</div>
