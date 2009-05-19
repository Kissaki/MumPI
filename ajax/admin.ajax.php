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
		
	case 'db_admins_echo':
		echo '<table><thead><tr><th>Username</th><th>Actions</th></tr>';
		$admins = DBManager::getInstance()->getAdmins();
		foreach($admins AS $admin){
			echo '<tr id="admin_list_'.$admin['id'].'"><td>'.$admin['name'].'</td><td><a class="jqlink" onclick="$(this).hide(); jq_admin_list_edit('.$admin['id'].');">edit</a> <a class="jqlink">delete</a></td></tr>';
		}
		echo '</thead></table>';
		break;
	case 'db_admin_update_name':
		DBManager::getInstance()->updateAdminName($_POST['name'], $_POST['pw']);
		break;
	case 'db_admin_add':
		DBManager::getInstance()->addAdminLogin($_POST['name'], $_POST['pw']);
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
	case 'server_setSuperuserPassword':
		ServerInterface::getInstance()->setServerSuperuserPassword($_POST['sid'], $_POST['pw']);
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
	
	case 'server_config_get':
		ServerInterface::getInstance()->getServerConfig($_POST['sid']);
		break;
	
	case 'server_config_show':
		if(!isset($_POST['sid'])) break;
		$_POST['sid'] = intval($_POST['sid']);
		$conf = ServerInterface::getInstance()->getServerConfig($_POST['sid']);
?>
		<h1>Server Config</h1>
		<p>For documentation, see your murmur.ini file (or <a href="http://mumble.git.sourceforge.net/git/gitweb.cgi?p=mumble;a=blob_plain;f=scripts/murmur.ini;hb=HEAD" rel="external">this</a> one in the repository, which may however differ from your version)
		<br/>
		<br/>
		<p style="font-size:x-small;">(Double-click entries to edit them)</p>
		<table><tbody>
			<tr class="table_headline"><td colspan="2">General</td></tr>
			<tr><td>Password</td>		<td class="jq_editable" id="jq_editable_server_conf_password"><?php echo $conf['password']; unset($conf['password']); ?></td></tr>
			<tr><td>Users</td>			<td class="jq_editable" id="jq_editable_server_conf_users"><?php echo $conf['users'];    unset($conf['users']); ?></td></tr>
			<tr><td>Timeout</td>		<td class="jq_editable" id="jq_editable_server_conf_timeout"><?php echo $conf['timeout'];  unset($conf['timeout']); ?></td></tr>
			<tr><td>Host</td>			<td class="jq_editable" id="jq_editable_server_conf_host"><?php echo $conf['host'];     unset($conf['host']); ?></td></tr>
			<tr><td>Port</td>			<td class="jq_editable" id="jq_editable_server_conf_port"><?php echo $conf['port'];     unset($conf['port']); ?></td></tr>
			<tr><td>Default Channel</td><td class="jq_editable" id="jq_editable_server_conf_defaultchannel"><?php echo $conf['defaultchannel']; unset($conf['defaultchannel']); ?></td></tr>
			<tr><td>welcometext</td>	<td class="jq_editable" id="jq_editable_server_conf_welcometext"><?php echo $conf['welcometext']; unset($conf['welcometext']); ?></td></tr>
			
			<tr class="table_headline">	<td colspan="2"></td></tr>
			<tr><td>bandwidth</td>		<td class="jq_editable" id="jq_editable_server_conf_bandwidth"><?php echo $conf['bandwidth']; unset($conf['bandwidth']); ?></td></tr>
			<tr><td>channelname</td>	<td class="jq_editable" id="jq_editable_server_conf_channelname"><?php echo $conf['channelname']; unset($conf['channelname']); ?></td></tr>
			<tr><td>playername</td>		<td class="jq_editable" id="jq_editable_server_conf_playername"><?php echo $conf['playername']; unset($conf['playername']); ?></td></tr>
			<tr><td>obfuscate</td>		<td class="jq_editable" id="jq_editable_server_conf_obfuscate"><?php echo $conf['obfuscate']; unset($conf['obfuscate']); ?></td></tr>
			
			<tr class="table_headline">	 <td colspan="2">Server Registration</td></tr>
			<tr><td>registerhostname</td><td class="jq_editable" id="jq_editable_server_conf_registerhostname"><?php echo $conf['registerhostname']; unset($conf['registerhostname']); ?></td></tr>
			<tr><td>registername</td>	 <td class="jq_editable" id="jq_editable_server_conf_registername"><?php echo $conf['registername']; unset($conf['registername']); ?></td></tr>
			<tr><td>registerpassword</td><td class="jq_editable" id="jq_editable_server_conf_registerpassword"><?php echo $conf['registerpassword']; unset($conf['registerpassword']); ?></td></tr>
			<tr><td>registerurl</td>	 <td class="jq_editable" id="jq_editable_server_conf_registerurl"><?php echo $conf['registerurl']; unset($conf['registerurl']); ?></td></tr>
			
<?php
		foreach($conf AS $key=>$val)
		{
?>
			<tr>
				<td><?php echo $key; ?></td>
				<td class="jq_editable" id="jq_editable_server_conf_<?php echo $key; ?>"><?php echo $val; ?></td>
			</tr>
<?php
		}
?>
		</tbody></table>
		<script type="text/javascript">
			function jq_editable_server_conf_onSubmit(obj, content)
			{
				var id = obj.attr('id');
				var subId = id.substring(id.lastIndexOf('_')+1, id.length);
				$.post('./?ajax=server_config_update',
					{ 'sid': <?php echo $_POST['sid']; ?>, 'key': subId, 'value': content.current },
					function(data)
					{
						jq_server_config_show(<?php echo $_POST['sid']; ?>);
					}
				);
			}
			function jq_editable_server_conf_text2textarea(key)
			{
				$('#jq_editable_server_conf_'+key).editable('destroy').editable({
					'type': 'textarea',
					'submit': 'save',
					'cancel':'cancel',
					'editBy': 'dblclick',
					'onSubmit': function(content){ jq_editable_server_conf_onSubmit($(this), content); }
				});
			}
			$('.jq_editable')
				.editable({
					'type': 'text',
					'submit': 'save',
					'cancel':'cancel',
					'editBy': 'dblclick',
					'onSubmit': function(content){ jq_editable_server_conf_onSubmit($(this), content); }
				});
			jq_editable_server_conf_text2textarea('welcometext');
			jq_editable_server_conf_text2textarea('certificate');
			jq_editable_server_conf_text2textarea('key');
		</script>
<?php
		break;
		
	case 'server_config_update':
		if(isset($_POST['sid']) && isset($_POST['key']) && isset($_POST['value']))
		{
			ServerInterface::getInstance()->setServerConfigEntry($_POST['sid'], $_POST['key'], $_POST['value']);
		}
		break;
	
		
	case 'server_user_updateUsername':
		ServerInterface::getInstance()->updateUserName($_POST['sid'], $_POST['uid'], $_POST['newValue']);
		break;
	case 'server_user_updateEmail':
		ServerInterface::getInstance()->updateUserEmail($_POST['sid'], $_POST['uid'], $_POST['newValue']);
		break;
	
	case 'meta_server_information_edit':
		$server = SettingsManager::getInstance()->getServerInformation($_POST['serverid']);

		echo '<div>';
		if($server === null)
		{
			echo 'new:<br/>';
			$server['name']              = '';
			$server['allowlogin']        = true;
			$server['allowregistration'] = true;
			$server['forcemail']         = true;
			$server['authbymail']        = false;
		}
		echo	'<table>';
		echo		'<tr><td>name</td>'
						.'<td><input type="text" id="meta_server_information_name" name="meta_server_information_name" value="'
						.$server['name'].'" /></td></tr>';
		echo		'<tr><td>Allow Login</td>'
						.'<td><input type="checkbox" id="meta_server_information_allowlogin" name="meta_server_information_allowlogin"'
						.($server['allowlogin'] ? ' checked="checked"' : '').'" /></tr>';
		echo		'<tr><td>Allow Registration</td>'
						.'<td><input type="checkbox" id="meta_server_information_allowregistration" name="meta_server_information_allowregistration"'
						.($server['allowregistration'] ? ' checked="checked"' : '').'" /></tr>';
		echo		'<tr><td>Force eMail</td>'
						.'<td><input type="checkbox" id="meta_server_information_forcemail" name="meta_server_information_forcemail"'
						.($server['forcemail'] ? ' checked="checked"' : '').'" /></tr>';
		echo		'<tr><td>Auth by Mail</td>'
						.'<td><input type="checkbox" id="meta_server_information_authbymail" name="meta_server_information_authbymail"'
						.($server['authbymail'] ? ' checked="checked"' : '').'" /></tr>';
		echo	'</table>';
		echo	'<input type="button" value="update" onclick="jq_meta_server_information_update('.$_POST['serverid'].');" />';
		echo	'<input type="button" value="cancel" onclick="$(\'#jq_information\').html(\'\');" />';
		echo '</div>';
		break;
	
	case 'meta_server_information_update':
		if(isset($_POST['name']) && isset($_POST['allowlogin']) && isset($_POST['allowregistration']) && isset($_POST['forcemail']) && isset($_POST['authbymail']) )
		{
			SettingsManager::getInstance()->setServerInformation($_POST['serverid'], $_POST['name'], $_POST['allowlogin'], $_POST['allowregistration'], $_POST['forcemail'], $_POST['authbymail']);
		}else{
			MessageManager::addError(TranslationManager::getInstance()->getText('error_missing_values'));
		}
		break;
		
		
}

?>