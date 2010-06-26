<?php
	if (isset($_GET['action']) && $_GET['action'] == 'dologin') {
		// login action
		if (isset($_POST['serverid']) && isset($_POST['name']) && isset($_POST['password'])) {
			// all required data received
			$tmpUid = ServerInterface::getInstance()->verifyPassword($_POST['serverid'],$_POST['name'],$_POST['password']);
			switch ($tmpUid) {

				case -2:
					MessageManager::addWarning(tr('login_unknownusername'));
					Logger::log_loginFail($_POST['serverid'], $_POST['name'], $_POST['password']);
					Logger::log("[{$_SERVER['REMOTE_ADDR']}] failed to log in as user $name.", Logger::LEVEL_SECURITY);
					break;

				case -1:
					MessageManager::addWarning(tr('login_wronglogininformation'));
					break;

				default:	// login success
					$_SESSION['serverid'] = $_POST['serverid'];
					$_SESSION['userid'] = $tmpUid;
					$_SESSION['userLoggedIn'] = true;
					echo '<script type="text/javascript">location.replace("?page=profile")</script>';
					echo tr('login_success');
					break;
			}
		} else {
			// missing mandatory data
			MessageManager::addError(tr('login_missing_data'));
		}
	} else {
		// no login-action, thus show login form
		?>

		<div id="content">
			<h1><?php echo tr('login_head'); ?></h1>
			<form action="./?page=login&amp;action=dologin" method="post" style="width:400px;">
				<table class="fullwidth">
					<tr>
						<td class="formitemname"><?php echo tr('server'); ?>:</td>
						<td>
							<?php $servers = SettingsManager::getInstance()->getServers(); ?>
							<select name="serverid">
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
						<td class="helpicon" title="<?php echo tr('help_login_server'); ?>"></td>
					</tr>
					<tr>
						<td class="formitemname"><?php echo tr('username'); ?>:</td>
						<td><input type="text" name="name" value="" /></td>
						<td class="helpicon" title="<?php echo tr('help_login_username'); ?>"></td>
					</tr><tr>
						<td class="formitemname"><?php echo tr('password'); ?>:</td>
						<td><input type="password" name="password" id="password" value="" /></td>
						<td class="helpicon" title="<?php echo tr('help_login_password'); ?>"></td>
					</tr>
				</table>
				<div class="alignc" style="margin-top:8px;">
					<input type="submit" value="<?php echo tr('login_button'); ?>" />
				</div>
			</form>
			<p style="margin-top:20px;">
				<?php echo tr('login_requestnote'); ?>
			</p>
		</div>
		<?php
	}
?>
