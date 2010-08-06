<?php
	require_once(SettingsManager::getInstance()->getMainDir().'/classes/Captcha.php');
	if (isset($_GET['action'])) {
		if ($_GET['action'] == 'doregister') {
			$_POST['serverid'] = intval($_POST['serverid']);
			if (!isset($_POST['serverid']) || empty($_POST['serverid'])) {
				// no Server specified
				MessageManager::addWarning(tr('register_fail_noserver'));
			} elseif (!isset($_POST['name']) || empty($_POST['name'])) {
				MessageManager::addWarning( tr('register_fail_noNameFound'));
			} elseif (!isset($_POST['password']) || empty($_POST['password']) || !isset($_POST['password2']) || empty($_POST['password2'])) {
				echo tr('register_fail_noPasswordFound');
			} elseif ($_POST['password'] != $_POST['password2']) {
				MessageManager::addWarning( tr('register_fail_passwordMatch'));
			} elseif (SettingsManager::getInstance()->isForceEmail($_POST['serverid']) && empty($_POST['email'])) {
				MessageManager::addWarning( tr('register_fail_noEmail'));
			} elseif (!empty($_POST['email'])	&& !HelperFunctions::isValidEmail($_POST['email'])) {
				MessageManager::addWarning( tr('register_fail_emailinvalid'));
			} elseif (SettingsManager::getInstance()->isUseCaptcha() && !Captcha::cap_isCorrect($_POST['spamcheck'])) {
				MessageManager::addWarning(tr('register_fail_wrongCaptcha'));
			}
			// Everything ok, check if auth by mail
			if (SettingsManager::getInstance()->isAuthByMail($_POST['serverid'])) {
				// create Auth by mail (send activation mail)
				// Add unactivated account and send mail
				if (ServerInterface::getInstance()->getServer(intval($_POST['serverid'])) != null) {
					// Server does exist
					DBManager::getInstance()->addAwaitingAccount($_POST['serverid'], $_POST['name'], $_POST['password'], $_POST['email']);
					echo tr('register_success_toActivate');
					Logger::log_registration($_POST['name']);
				} else {
					// Server does not exist, add warning
					MessageManager::addWarning(tr('unknownserver'));
				}
			} else {
				// non-auth-by-mail, just add registration
				ServerInterface::getInstance()->addUser($_POST['serverid'], $_POST['name'], $_POST['password'], $_POST['email']);
				echo tr('register_success');
				Logger::log_registration($_POST['name']);
			}
		} elseif ($_GET['action'] == 'activate' && isset($_GET['key'])) {
			// Activate account
			DBManager::getInstance()->activateAccount($_GET['key']);
			echo tr('register_activate_success');
		}

	} else {
		// no form data received -> display registration form
?>

<div id="content">
	<h1><?php echo tr('register_title'); ?></h1>
	<form action="./?page=register&amp;action=doregister" method="post" style="width:400px;">
		<table class="fullwidth">
			<tr>
				<td class="formitemname"><?php echo tr('server'); ?>:</td>
				<td>
					<?php $servers = ServerInterface::getInstance()->getServers(); ?>
					<select name="serverid" style="width:100%">
						<?php
							foreach ($servers AS $server) {
								// Check that server allows registration and does exist
								$serverDB = SettingsManager::getInstance()->getServerInformation($server->id());
								if ($serverDB['allowregistration']) {
									echo '<option value="'.$server->id().'">';
									echo $serverDB['name'];
									echo '</option>';
								}
							}
						?>
					</select>
				</td>
				<td class="helpicon" title="<?php echo tr('register_help_server'); ?>"></td>
			</tr>
			<tr>
				<td class="formitemname"><?php echo tr('username'); ?>:</td>
				<td><input type="text" name="name" value="" /></td>
				<td class="helpicon" title="<?php echo tr('register_help_username'); ?>"></td>
			</tr><tr>
				<td class="formitemname"><?php echo tr('email'); ?>:</td>
				<td><input type="text" name="email" value="" /></td>
				<td class="helpicon" title="<?php echo tr('register_help_email'); ?>"></td>
			</tr><tr>
				<td class="formitemname"><?php echo tr('password'); ?>:</td>
				<td><input type="password" name="password" id="password" value="" /></td>
				<td class="helpicon" title="<?php echo tr('register_help_password'); ?>"></td>
			</tr><tr>
				<td class="formitemname"><?php echo tr('password_repeat'); ?>:</td>
				<td><input type="password" name="password2" id="password2" value="" /></td>
				<td class="helpicon" title="<?php echo tr('register_help_password2'); ?>"></td>
<?php
			if (SettingsManager::getInstance()->isUseCaptcha()) {
?>
			</tr><tr>
				<td class="formitemname"><?php echo tr('antispam'); ?>:</td>
				<td></td>
				<td></td>
			</tr><tr>
				<td class="formitemname"><?php Captcha::cap_show(); ?> =</td>
				<td><input type="text" name="spamcheck" value="" /></td>
				<td class="helpicon" title="<?php echo tr('register_help_captcha'); ?>"></td>
<?php
			}
?>
			</tr>
		</table>
		<div class="alignc"><input type="submit" value="<?php echo tr('register'); ?>" /></div>
	</form>
</div>
<?php } ?>
