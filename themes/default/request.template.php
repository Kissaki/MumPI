<?php
if( isset($_POST['email']) && !empty($_POST['email']) ){
	$_POST['email'] = trim($_POST['email']);
	if( isset($_POST['password']) && isset($_POST['username']) ){
		$user = ServerInterface::getInstance()->getUserByEmail(intval($_POST['serverid']), $_POST['email']);
		if($user != null){
			$newPw = substr(md5(rand()), 4, 8);
			ServerInterface::getInstance()->updateUserPw(intval($_POST['serverid']), $user->playerid, $newPw);
			mail($_POST['email'], 'Login Information', 'You have requested your login and a new password.'."\n\n".
				'Username: '.$user->name."\n".
				'New Password: '.$newPw);
			$formProcessed = 'The information was just sent.<br/>Please Check your mails in a few minutes.<br/>Depending on your mail provider, it may take some time for the mail to arrive or may be put into a junk folder.<br/>MSN/Live may even block the mail entirely, so if it does not work, ask an admin about this.';
		}else{
			echo '<div class="error">No account with that email address was found on that server.<br/><a onclick="history.go(-1); return false;" href="?section=login">Go back</a> and check your input.</div>';
		}
		
	}elseif( isset($_POST['password']) ){
		$user = ServerInterface::getInstance()->getUserByEmail(intval($_POST['serverid']), $_POST['email']);
		if($user != null){
			$newPw = substr(md5(rand()), 4, 8);
			ServerInterface::getInstance()->updateUserPw(intval($_POST['serverid']), $user->playerid, $newPw);
			mail($_POST['email'], 'New Mumble Password', 'You have requested a new password.'."\n\n".
				'New Password: '.$newPw);
			$formProcessed = 'The information was just sent.<br/>Please Check your mails in a few minutes.<br/>Depending on your mail provider, it may take some time for the mail to arrive or may be put into a junk folder.<br/>MSN/Live may even block the mail entirely, so if it does not work, ask an admin about this.';
		}else{
			echo '<div class="error">No account with that email address was found on that server.<br/><a onclick="history.go(-1); return false;" href="?section=login">Go back</a> and check your input.</div>';
		}
	}elseif( isset($_POST['username']) ){
		$user = ServerInterface::getInstance()->getUserByEmail(intval($_POST['serverid']), $_POST['email']);
		if($user != null){
			mail($_POST['email'], 'Mumble Login Information', 'You have requested your login name.'."\n\n".
				'Username: '.$user->name);
			$formProcessed = 'The information was just sent.<br/>Please Check your mails in a few minutes.<br/>Depending on your mail provider, it may take some time for the mail to arrive or may be put into a junk folder.<br/>MSN/Live may even block the mail entirely, so if it does not work, ask an admin about this.';
		}else{
			echo '<div class="error">No account with that email address was found on that server.<br/><a onclick="history.go(-1); return false;" href="?section=login">Go back</a> and check your input.</div>';
		}
	}
}
?>
<div id="content">
	<?php if(isset($formProcessed)){ ?>
		<h1 class="alignc">Data Sent</h1>
		<p><?php echo $formProcessed; ?></p>
	<?php }else{ ?>
	<h1><?php TranslationManager::echoText('request_head'); ?></h1>
	<form action="./?section=request&amp;action=dorequest" method="post" class="alignc" style="width:400px;">
		<table class="fullwidth alignl">
			<tr>
				<td class="formitemname"><?php echo TranslationManager::getText('server'); ?>:</td>
				<td>
					<?php $servers = SettingsManager::getInstance()->getServers(); ?>
					<select name="serverid" style="width:100%">
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
				<td class="helpicon" title="<?php TranslationManager::echoText('help_request_selectmumbleserver'); ?>"></td>
			</tr><tr>
				<td class="formitemname"><?php echo TranslationManager::getText('email'); ?>:</td>
				<td><input type="text" name="email" value="" /></td>
				<td class="helpicon" title="<?php TranslationManager::echoText('help_request_email'); ?>"></td>
			</tr><tr>
				<td class="formitemname"><?php TranslationManager::echoText('request_selection'); ?>:</td>
				<td><input type="checkbox" name="password"/> <?php echo TranslationManager::getText('password'); ?></td>
				<td></td>
			</tr><tr>
				<td></td>
				<td><input type="checkbox" name="username"/> <?php echo TranslationManager::getText('username'); ?></td>
				<td></td>
			</tr>
		</table><br/>
		<input type="submit" value="<?php TranslationManager::echoText('request_button'); ?>" />
	</form>
	<?php } ?>
</div>