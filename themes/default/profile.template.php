<?php
session_start();
?>
<h1>Edit Profile</h1>
<form action="?section=profile&ampaction=doedit" method="post">
	<table>
		<tr>
			<td class="formitemname"><?php echo $txt['server']; ?>:</td>
			<td>
				<?php
					echo SettingsManager::getInstance()->getServerName($_SESSION['serverid']);
				?>
			</td><td class="helpicon">
			</td>
		</tr>
		<tr>
			<td class="formitemname"><?php echo $txt['username']; ?>:</td><td><input type="text" name="name" value="" /></td><td class="helpicon"></td>
		</tr><tr>
			<td class="formitemname"><?php echo $txt['password']; ?>:</td><td><input type="text" name="password" id="password" value="" /></td><td class="helpicon"></td>
		</tr>
	</table>
	<input type="submit" value="login" />
</form>