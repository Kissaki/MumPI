<?php
	if(isset($_GET['action']) && $_GET['action']='doregister'){
		//TODO: register user to server
		//TODO: Add optional mail activation
		//TODO: security: check posted vars
		if(!isset($_POST['serverid']) || $_POST['serverid']=='' ){
			echo 'no server specified!<br/><a onclick="history.go(-1); return false;" href="?section=register">go back</a>';
		}elseif( !isset($_POST['name']) || empty($_POST['name']) ){
			echo 'no server specified!<br/><a onclick="history.go(-1); return false;" href="?section=register">go back</a>';
		}elseif( !isset($_POST['password']) || empty($_POST['password'])
			|| !isset($_POST['password2']) || empty($_POST['password2']) ){
				echo 'no password specified!<br/><a onclick="history.go(-1); return false;" href="?section=register">go back</a>';
		}elseif( $_POST['password'] != $_POST['password2']){
			echo 'Your passwords did not match!<br/><a onclick="history.go(-1); return false;" href="?section=register">go back</a>';
		}else{
			echo 'registering on server with id '.$_POST['serverid'].'...<br/>';
			try{
				$tmpServer = $dbIObj->getServer($_POST['serverid']);
				$tmpUid = $tmpServer->registerPlayer($_POST['name']);
				$tmpReg = $tmpServer->getRegistration($tmpUid);
				echo $txt['doregister_success'];
			}catch(InvalidServerException $exc){
				echo 'invalid server<br/>';
			}catch(ServerBootedException $exc){
				echo 'Server is currently not running, but it has to to register.<br/>Please contact a server admin';
			}catch(Ice_UnknownUserException $exc){
				switch($exc->unknown){
					case 'Murmur::InvalidServerException':
						echo 'Invalid server. Please check your server selection.<br/><a onclick="history.go(-1); return false;" href="?section=register">go back</a><br/>If the problem persists, please contact a server admin or webmaster.<br/>';
						break;
						
					case 'Murmur::ServerBootedException':
						echo 'Server is currently not running, but it has to to register.<br/>Please contact a server admin';
						break;
						
					case 'Murmur::InvalidPlayerException':
						echo 'The username you specified is probably already in use. Please try another one.<br/><a onclick="history.go(-1); return false;" href="?section=register">go back</a>';
						break;
				}
				echo $exc->unknown.'<br/>';
				echo '<pre>'; var_dump($exc); echo '</pre>';
			}
		}
	}else{	// no form data received -> display registration form
?>

<div id="content">
	<form action="./?section=register&amp;action=doregister" method="post">
		<table>
			<?php // Only allow Server selection, if more than one exist
				if($muPI_sett_server['numberOfServers'] == 1){ ?>
			<tr>
				<td class="formitemname"><?php echo $txt['server']; ?>:</td>
				<td>
					<?php $servers = $dbIObj->getServers(); ?>
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
			<?php } ?>
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
