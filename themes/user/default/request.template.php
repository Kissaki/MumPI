<?php
if (isset($_POST['email']) && !empty($_POST['email'])) {
	$_POST['email'] = trim($_POST['email']);
	if (isset($_POST['password']) && isset($_POST['username'])) {
		// Send username and new password
		$user = ServerInterface::getInstance()->getUserByEmail(intval($_POST['serverid']), $_POST['email']);
		if ($user != null) {
			$newPw = substr(md5(rand()), 4, 8);
			ServerInterface::getInstance()->updateUserPw(intval($_POST['serverid']), $user->getUserId(), $newPw);
			mail($_POST['email'], tr('request_mail_up_subj'), sprintf(tr('request_mail_up_body'), $user->getName(), $newPw) );
			$formProcessed = tr('request_mail_sent');
		} else {
			MessageManager::addWarning(tr('request_nosuchaccount'));
		}
	} elseif (isset($_POST['password'])) {
		// send new password
		$user = ServerInterface::getInstance()->getUserByEmail(intval($_POST['serverid']), $_POST['email']);
		if ($user != null) {
			$newPw = substr(md5(rand()), 4, 8);
			ServerInterface::getInstance()->updateUserPw(intval($_POST['serverid']), $user->getUserId(), $newPw);
			mail($_POST['email'], tr('request_mail_p_subj'), sprintf(tr('request_mail_p_body'), $newPw) );
			$formProcessed = tr('request_mail_sent');
		} else {
			MessageManager::addWarning(tr('request_nosuchaccount'));
		}
	} elseif (isset($_POST['username'])) {
		// send username
		$user = ServerInterface::getInstance()->getUserByEmail(intval($_POST['serverid']), $_POST['email']);
		if ($user != null) {
			mail($_POST['email'], tr('request_mail_u_subj'), sprintf(tr('request_mail_u_body'), $user->getName()) );
			$formProcessed = tr('request_mail_sent');
		} else {
			MessageManager::addWarning(tr('request_nosuchaccount'));
		}
	}
}
?>
<div id="content">
	<?php if (isset($formProcessed)) { ?>
		<h1 class="alignc">Data Sent</h1>
		<p><?php echo $formProcessed; ?></p>
	<?php } else { ?>
	<h1><?php echo tr('request_head'); ?></h1>
	<form action="./?page=request&amp;action=dorequest" method="post" class="alignc" style="width:400px;">
		<table class="fullwidth alignl">
			<tr>
				<td class="formitemname"><?php echo tr('server'); ?>:</td>
				<td>
					<?php $servers = SettingsManager::getInstance()->getServers(); ?>
					<select name="serverid" style="width:100%">
						<?php
							foreach ($servers AS $sid=>$server) {
								// Check that server allows login and does exist
								if ($server['allowlogin'] && ServerInterface::getInstance()->getServer($sid)!=null) {
									echo '<option value="'.$sid.'">';
									echo $server['name'];
									echo '</option>';
								}
							}
						?>
					</select>
				</td>
				<td class="helpicon" title="<?php echo tr('help_request_selectmumbleserver'); ?>"></td>
			</tr><tr>
				<td class="formitemname"><?php echo tr('email'); ?>:</td>
				<td><input type="text" name="email" value="" /></td>
				<td class="helpicon" title="<?php echo tr('help_request_email'); ?>"></td>
			</tr><tr>
				<td class="formitemname"><?php echo tr('request_selection'); ?>:</td>
				<td><input type="checkbox" name="password"/> <?php echo tr('password'); ?></td>
				<td></td>
			</tr><tr>
				<td></td>
				<td><input type="checkbox" name="username"/> <?php echo tr('username'); ?></td>
				<td></td>
			</tr>
		</table><br/>
		<input type="submit" value="<?php echo tr('request_button'); ?>" />
	</form>
	<?php } ?>
</div>