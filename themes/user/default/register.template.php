<?php
	require_once(SettingsManager::getInstance()->getMainDir().'/classes/Captcha.php');
	if( isset($_GET['action']) ){
		if( $_GET['action']=='doregister' ){
			if(!isset($_POST['serverid']) || empty($_POST['serverid']) ){
				echo tr('register_fail_noserver');
			}elseif( !isset($_POST['name']) || empty($_POST['name']) ){
				echo tr('register_fail_noNameFound');
			}elseif( !isset($_POST['password']) || empty($_POST['password'] )
				|| !isset($_POST['password2']) || empty($_POST['password2']) ){
					echo tr('register_fail_noPasswordFound');
			}elseif( $_POST['password'] != $_POST['password2'] ){
				echo tr('register_fail_passwordMatch');
			}elseif( SettingsManager::getInstance()->isForceEmail($_POST['serverid']) && empty($_POST['email']) ){
				echo tr('register_fail_noEmail');
			}elseif( SettingsManager::getInstance()->isAuthByMail($_POST['serverid']) ){
				if( Captcha::cap_isCorrect($_POST['spamcheck']) ){
					// Add unactivated account and send mail
					if(ServerInterface::getInstance()->getServer(intval($_POST['serverid']))==null)
						die('no such server');
					DBManager::getInstance()->addAwaitingAccount($_POST['serverid'], $_POST['name'], $_POST['password'], $_POST['email']);
					echo tr('register_success_toActivate');
					Logger::log_registration($_POST['name']);
				}else{
					echo tr('register_fail_wrongCaptcha');
				}
			}else{
				if( Captcha::cap_isCorrect($_POST['spamcheck']) ){
					// Input ok, now do try to register
					ServerInterface::getInstance()->addUser($_POST['serverid'], $_POST['name'], $_POST['password'], $_POST['email']);
					echo tr('register_success');
					Logger::log_registration($_POST['name']);
				}else{
					echo tr('register_fail_wrongCaptcha');
				}
			}
		}elseif( $_GET['action']=='activate' && isset($_GET['key']) ){
			DBManager::getInstance()->activateAccount($_GET['key']);
			echo tr('register_activate_success');
		}
		
	}else{	// no form data received -> display registration form
?>

<div id="content">
	<h1>Registration Form</h1>
	<form action="./?page=register&amp;action=doregister" method="post" style="width:400px;">
		<table class="fullwidth">
			<tr>
				<td class="formitemname"><?php echo tr('server'); ?>:</td>
				<td>
					<?php $servers = SettingsManager::getInstance()->getServers(); ?>
					<select name="serverid" style="width:100%">
						<?php 
							foreach($servers AS $sid=>$server){
								// Check that server allows registration and does exist
								if($server['allowregistration'] && ServerInterface::getInstance()->getServer($sid)!=null){
									echo '<option value="'.$sid.'">';
									echo $server['name'];
									echo '</option>';
								}
							}
						?>
					</select>
				</td><td class="helpicon">
				</td>
			</tr>
			<tr>
				<td class="formitemname"><?php echo tr('username'); ?>:</td>
				<td><input type="text" name="name" value="" /></td>
				<td class="helpicon"></td>
			</tr><tr>
				<td class="formitemname"><?php echo tr('email'); ?>:</td>
				<td><input type="text" name="email" value="" /></td>
				<td class="helpicon"></td>
			</tr><tr>
				<td class="formitemname"><?php echo tr('password'); ?>:</td>
				<td><input type="password" name="password" id="password" value="" /></td>
				<td class="helpicon"></td>
			</tr><tr>
				<td class="formitemname"><?php echo tr('password_repeat'); ?>:</td>
				<td><input type="password" name="password2" id="password2" value="" /></td>
				<td class="helpicon"></td>
			</tr><tr>
				<td class="formitemname"><?php echo tr('antispam'); ?>:</td>
				<td></td>
				<td></td>
			</tr><tr>
				<td class="formitemname"><?php Captcha::cap_show(); ?> =</td>
				<td><input type="text" name="spamcheck" value="" /></td>
				<td class="helpicon" title="<?php echo tr('register_help_captcha'); ?>"></td>
			</tr>
		</table>
		<div class="alignc"><input type="submit" value="<?php echo tr('register'); ?>" /></div>
	</form>
</div>
<?php } ?>
