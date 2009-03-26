<?php
/**
 * Ajax functionality
 * @author Kissaki
 */
//TODO secure this with $_SERVER['HTTP_REFERER']
//TODO secure this, preferably session data

switch($_GET['ajax']){
	case 'getPage':
		TemplateManager::parseTemplate($_GET['page']);
		break;
		
	case 'meta_showDefaultConfig':
		$config = ServerInterface::getInstance()->getDefaultConfig();
		echo '<table>';
		foreach($config AS $key=>$value){
			echo '<tr><td>'.$key.':</td><td>'.$value.'</td></tr>';
		}
		echo '</table>';
		break;
		
	case 'server_create':
		echo ServerInterface::getInstance()->createServer();
		break;
	case 'server_delete':
		ServerInterface::getInstance()->deleteServer($_POST['sid']);
		break;
	case 'server_start':
		ServerInterface::getInstance()->startServer($_POST['sid']);
		break;
	case 'server_stop':
		ServerInterface::getInstance()->stopServer($_POST['sid']);
		break;
		
	case 'server_getRegistrations':
		$users = array();
		try{
			$users = ServerInterface::getInstance()->getServerRegistrations($_POST['sid']);
		}catch(Murmur_ServerBootedException $exc){
			echo '<div class="error">Server is not running</div>';
			break;
		}
		?>
			<h2>Registrations</h2>
			<table>
				<thead>
					<tr>
						<th>User ID</th>
						<th>Username</th>
						<th>email</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
<?php				foreach($users AS $user){	?>
					<tr>
						<td><?php echo $user->playerid; ?></td>
						<td id="user_name_<?php echo $user->playerid; ?>" class="jq_editable"><?php echo $user->name; ?></td>
						<td id="user_email_<?php echo $user->playerid; ?>" class="jq_editable"><?php echo $user->email; ?></td>
						<td><a class="jqlink" onclick="jq_server_registration_remove(<?php echo $user->playerid; ?>)">remove</a></td>
					</tr>
<?php				}	?>
				</tbody>
			</table>
		<?php
		break;
	
	case 'show_onlineUsers':
		$users = array();
		try{
			$users = ServerInterface::getInstance()->getServerUsersConnected($_POST['sid']);
		}catch(Murmur_ServerBootedException $exc){
			echo '<div class="error">Server is not running</div>';
			break;
		}
?>
			<h2>Online Users</h2>
			<table>
				<thead>
					<tr>
						<th>Sess ID</th>
						<th>Reg ID</th>
						<th>Username</th>
						<th>muted?</th>
						<th>deaf?</th>
						<th>Seconds online</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
<?php				foreach($users AS $user){	?>
					<tr>
						<td><?php echo $user->session; ?></td>
						<td><?php if($user->playerid > 0) echo $user->playerid; ?></td>
						<td id="user_name_<?php echo $user->session; ?>" class="jq_editable"><?php echo $user->name; ?></td>
						<td><input id="user_mute_<?php echo $user->session; ?>" class="jq_toggleable" type="checkbox" <?php if($user->mute) echo 'checked=""' ; ?>/></td>
						<td><input id="user_deaf_<?php echo $user->session; ?>" class="jq_toggleable" type="checkbox" <?php if($user->deaf) echo 'checked=""' ; ?>/></td>
						<td id="user_email_<?php echo $user->session; ?>" class="jq_editable"><?php $on = $user->onlinesecs; if($on > 59){ echo sprintf('%.0f', $on/60).'m'; }else{ echo $on.'s'; } ?></td>
						<td><a class="jqlink" onclick="jq_server_user_kick(<?php echo $user->session; ?>)">kick</a></td>
<?php						// <a class="jqlink" onclick="jq_server_user_ban(<?php echo $user->session; ?\>)">ban</a>	?>
					</tr>
<?php				}	?>
				</tbody>
			</table>
			<script type="text/javascript">
				$('.jq_toggleable').click(
						function(event){
							var id = $(this).attr('id');
							var sub = id.substring(0, id.lastIndexOf('_'));
							var id = id.substring(id.lastIndexOf('_')+1, id.length);
							switch(sub){
								case 'user_mute':
									if($(this).attr('checked')){
										jq_server_user_mute(id);
									}else{
										jq_server_user_unmute(id);
									}
									
									break;
								case 'user_deaf':
									if($(this).attr('checked')){
										jq_server_user_deaf(id);
									}else{
										jq_server_user_undeaf(id);
									}
									break;
							}
						}
					);
			</script>
<?php
		break;
		
	case 'server_regstration_remove':
		ServerInterface::getInstance()->removeRegistration($_POST['sid'], $_POST['uid']);
		break;
	case 'server_user_mute':
		ServerInterface::getInstance()->muteUser($_POST['sid'], $_POST['sessid']);
		break;
	case 'server_user_unmute':
		ServerInterface::getInstance()->unmuteUser($_POST['sid'], $_POST['sessid']);
		break;
	case 'server_user_deaf':
		ServerInterface::getInstance()->deafUser($_POST['sid'], $_POST['sessid']);
		break;
	case 'server_user_undeaf':
		ServerInterface::getInstance()->undeafUser($_POST['sid'], $_POST['sessid']);
		break;
	case 'server_user_kick':
		ServerInterface::getInstance()->kickUser($_POST['sid'], $_POST['sessid']);
		break;
	case 'server_user_ban':
		ServerInterface::getInstance()->banUser($_POST['sid'], $_POST['sessid']);
		break;
	case 'show_server_bans':
		$bans = ServerInterface::getInstance()->getServerBans($_POST['sid']);
		echo '<h2>Bans</h2>';
		echo '<p><a>add</a></p>';
		if(count($bans)==0){
			echo 'no bans on this virtual server';
		}else{
			echo '<ul>';
			foreach($bans AS $ban){
				echo '<li>'.$ban->address.'</li>';
			}
			echo '</ul>';
		}
		break;
		
	case 'show_tree':
		$tree = ServerInterface::getInstance()->getServer($_POST['sid'])->getTree();
		HelperFunctions::showChannelTree($tree);
		break;
		
	case 'show_acl':
		
		break;
		
	case 'server_showConfig':
		$config = ServerInterface::getInstance()->getServerConfig($_POST['sid']);
?>
		<table><tbody>
			<tr>
				<td>welcome text</td>
				<td><?php echo ServerInterface::getInstance()->getServerConfigEntry($_POST['sid'], 'welcometext'); ?></td>
			</tr>
		</tbody></table>
<?php
		echo '<pre>'; var_dump($config); echo '</pre>';
		break;
	
		
	case 'server_user_updateUsername':
		ServerInterface::getInstance()->updateUserName($_POST['sid'], $_POST['uid'], $_POST['newValue']);
		break;
	case 'server_user_updateEmail':
		ServerInterface::getInstance()->updateUserEmail($_POST['sid'], $_POST['uid'], $_POST['newValue']);
		break;
	
}

?>