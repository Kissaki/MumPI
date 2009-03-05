<?php
	require_once(SettingsManager::getInstance()->getMainDir().'/classes/Captcha.php');
	if( isset($_GET['action']) ){
		if( $_GET['action']=='doregister' ){
			if(!isset($_POST['serverid']) || empty($_POST['serverid']) ){
				echo 'no server specified!<br/><a onclick="history.go(-1); return false;" href="?section=register">go back</a>';
			}elseif( !isset($_POST['name']) || empty($_POST['name']) ){
				echo 'no name specified!<br/><a onclick="history.go(-1); return false;" href="?section=register">go back</a>';
			}elseif( !isset($_POST['password']) || empty($_POST['password'] )
				|| !isset($_POST['password2']) || empty($_POST['password2']) ){
					echo 'no password specified!<br/><a onclick="history.go(-1); return false;" href="?section=register">go back</a>';
			}elseif( $_POST['password'] != $_POST['password2'] ){
				echo 'Your passwords did not match!<br/><a onclick="history.go(-1); return false;" href="?section=register">go back</a>';
			}elseif( SettingsManager::getInstance()->isForceEmail($_POST['serverid']) && empty($_POST['email']) ){
				echo 'You did not enter an email address, however, this is required.<br/><a onclick="history.go(-1); return false;" href="?section=register">go back</a>';
			}elseif( SettingsManager::getInstance()->isAuthByMail($_POST['serverid']) ){
				if( Captcha::cap_isCorrect($_POST['spamcheck']) ){
					// Add unactivated account and send mail
					if(ServerInterface::getInstance()->getServer(intval($_POST['serverid']))==null)
						die('no such server');
					DBManager::getInstance()->addAwaitingAccount($_POST['serverid'], $_POST['name'], $_POST['password'], $_POST['email']);
					echo 'You have successfully registered, however, your account is not activated yet.<br/>You will receive an email soon with an activation link you have to click.';
					Logger::log_registration($_POST['name']);
				}else{
					echo '<div class="error">Captcha Incorrect.</div>';
				}
			}else{
				if( Captcha::cap_isCorrect($_POST['spamcheck']) ){
					// Input ok, now do try to register
					ServerInterface::getInstance()->addUser($_POST['serverid'], $_POST['name'], $_POST['password'], $_POST['email']);
					echo 'You have successfully registered. You can now <a href="?section=login">log in</a> (also in mumble).';
					Logger::log_registration($_POST['name']);
				}else{
					echo '<div class="error">Captcha Incorrect.</div>';
				}
			}
		}elseif( $_GET['action']=='activate' && isset($_GET['key']) ){
			DBManager::getInstance()->activateAccount($_GET['key']);
		}
		
	}else{	// no form data received -> display registration form
?>

<div id="content">
	<h1>Registration Form</h1>
	<form action="./?section=register&amp;action=doregister" method="post" style="width:400px;">
		<table class="fullwidth">
			<tr>
				<td class="formitemname"><?php echo $txt['server']; ?>:</td>
				<td>
					<?php $servers = SettingsManager::getInstance()->getServers(); ?>
					<select name="serverid" style="width:100%">
						<?php 
							foreach($servers AS $server){
								// Check that server allows registration and does exist
								if($server['allowregistration'] && ServerInterface::getInstance()->getServer($server['id'])!=null){
									echo '<option value="'.$server['id'].'">';
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
				<td class="formitemname"><?php echo $txt['username']; ?>:</td>
				<td><input type="text" name="name" value="" /></td>
				<td class="helpicon"></td>
			</tr><tr>
				<td class="formitemname"><?php echo $txt['email']; ?>:</td>
				<td><input type="text" name="email" value="" /></td>
				<td class="helpicon"></td>
			</tr><tr>
				<td class="formitemname"><?php echo $txt['password']; ?>:</td>
				<td><input type="password" name="password" id="password" value="" /></td>
				<td class="helpicon"></td>
			</tr><tr>
				<td class="formitemname"><?php echo $txt['password_repeat']; ?>:</td>
				<td><input type="password" name="password2" id="password2" value="" /></td>
				<td class="helpicon"></td>
			</tr><tr>
				<td class="formitemname">Anti-Spam:</td>
				<td></td>
				<td></td>
			</tr><tr>
				<td class="formitemname"><?php Captcha::cap_show(); ?> =</td>
				<td><input type="text" name="spamcheck" value="" /></td>
				<td class="helpicon" title="This field is to prevent spam.
Calculate the result and enter it into the text box."></td>
			</tr>
		</table>
		<div class="alignc"><input type="submit" value="register" /></div>
	</form>
</div>
<?php } ?>
