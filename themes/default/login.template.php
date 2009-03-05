<?php
if(isset($_GET['action']) && $_GET['action'] == 'dologin' ){
	$tmpUid = ServerInterface::getInstance()->verifyPassword($_POST['serverid'],$_POST['name'],$_POST['password']);
	switch($tmpUid){
		case -2:
			echo 'Unknown username.<br/><a onclick="history.go(-1); return false;" href="?section=login">Go back</a> and check your input.<br/>'.
				'If you forgot your login or password, <a href="?section=request">request it</a>.';
			break;
		case -1:
			// TODO: forgot/reset pw link
			echo 'wrong login information<br/><a onclick="history.go(-1); return false;" href="?section=login">go back</a><br/>'.
				'If you forgot your login or password, <a href="?section=request">request it</a>.';
			break;
		default:	// login success
			$_SESSION['serverid'] = $_POST['serverid'];
			$_SESSION['userid'] = $tmpUid;
			echo '<script type="text/javascript">location.replace("?section=profile")</script>';
			echo 'Successfull login.<br/><a href="?section=profile">profile</a>';
			break;
	}
}else{
?>

<div id="content">
	<h1>Login Form</h1>
	<form action="./?section=login&amp;action=dologin" method="post" style="width:400px;">
		<table class="fullwidth">
			<tr>
				<td class="formitemname" style="width:1px;"><?php echo TranslationManager::getInstance()->getText('server'); ?>:</td>
				<td>
					<?php $servers = SettingsManager::getInstance()->getServers(); ?>
					<select name="serverid">
						<?php
							foreach($servers AS $server){
								// Check that server allows login and does exist
								if($server['allowlogin'] && ServerInterface::getInstance()->getServer($server['id'])!=null){
									echo '<option value="'.$server['id'].'">';
									echo $server['name'];
									echo '</option>';
								}
							}
						?>
					</select>
				</td>
				<td class="helpicon" title="<?php echo $txt['help_login_server']; ?>"></td>
			</tr>
			<tr>
				<td class="formitemname"><?php echo $txt['username']; ?>:</td>
				<td><input type="text" name="name" value="" /></td>
				<td class="helpicon" title="<?php echo $txt['help_login_username']; ?>"></td>
			</tr><tr>
				<td class="formitemname"><?php echo $txt['password']; ?>:</td>
				<td><input type="password" name="password" id="password" value="" /></td>
				<td class="helpicon" title="<?php echo $txt['help_login_password']; ?>"></td>
			</tr>
		</table>
		<div class="alignc" style="margin-top:8px;"><input type="submit" value="login" /></div>
	</form>
	<p style="margin-top:20px;">If you forgot your login or password, you can <a href="?section=request">request it</a>.</p>
</div>
<?php } ?>
