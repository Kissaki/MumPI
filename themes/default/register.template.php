<?php
	if( isset($_GET['action']) && $_GET['action']='doregister' ){
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
			// Add unactivated account and send mail
			
		}else{
			// Input ok, now do register
			echo $txt['doregister_try'].'<br/>';
			try{
				$tmpServer = ServerDatabase::getInstance()->getServer(intval($_POST['serverid']));
				if(empty($tmpServer)){
					echo 'Server could not be found.<br/>';
					die();
				}
				$tmpUid = $tmpServer->registerPlayer($_POST['name']);
				$tmpReg = $tmpServer->getRegistration($tmpUid);
				$tmpReg->pw = $_POST['password'];
				if(!empty($_POST['email']))
					$tmpReg->email = $_POST['email'];
				$tmpReg = $tmpServer->updateregistration($tmpReg);
				echo $txt['doregister_success'].'<br/>';
			}catch(InvalidServerException $exc){	// This is depreciated (murmur.ice)
				echo 'Invalid server. Please check your server selection.<br/><a onclick="history.go(-1); return false;" href="?section=register">go back</a><br/>If the problem persists, please contact a server admin or webmaster.<br/>';
			}catch(ServerBootedException $exc){
				echo 'Server is currently not running, but it has to to be able to register.<br/>Please contact a server admin';
			}catch(InvalidPlayerException $exc){
				echo 'The username you specified is probably already in use or invalid. Please try another one.<br/><a onclick="history.go(-1); return false;" href="?section=register">go back</a>';
			}catch(Ice_UnknownUserException $exc){	// This should not be caught
				echo $exc->unknown.'<br/>';
//				echo '<pre>'; var_dump($exc); echo '</pre>';
			}
		}
	}else{	// no form data received -> display registration form
?>

<div id="content">
	<form action="./?section=register&amp;action=doregister" method="post">
		<table>
			<tr>
				<td class="formitemname"><?php echo $txt['server']; ?>:</td>
				<td>
					<?php $servers = ServerDatabase::getInstance()->getServers(); ?>
					<select name="serverid" style="width:100%">
						<?php 
							foreach($servers AS $key=>$server){
								$srvid = intval($server->id());
								echo '<option value="'.$srvid.'">';
								echo $muPI_sett_server[$srvid]['name'];
								echo '</option>';
							}
						?>
					</select>
				</td><td class="helpicon">
				</td>
			</tr>
			<tr>
				<td class="formitemname"><?php echo $txt['username']; ?>:</td><td><input type="text" name="name" value="" /></td><td class="helpicon"></td>
			</tr><tr>
				<td class="formitemname"><?php echo $txt['email']; ?>:</td><td><input type="text" name="email" value="" /></td><td class="helpicon"></td>
			</tr><tr>
				<td class="formitemname"><?php echo $txt['password']; ?>:</td><td><input type="text" name="password" id="password" value="" /></td><td class="helpicon"></td>
			</tr><tr>
				<td class="formitemname"><?php echo $txt['password_repeat']; ?>:</td><td><input type="text" name="password2" id="password2" value="" /></td><td class="helpicon"></td>
			</tr>
		</table>
		<input type="submit" value="register" />
	</form>
</div>
<?php } ?>
