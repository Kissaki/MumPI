<?php
	if (!isset($_GET['sid']) || empty($_GET['sid'])) {
		$servers = ServerInterface::getInstance()->getServers();
?>
		<h1>Select a server</h1>
		<ul>
<?php
			foreach ($servers AS $server) {
				if (PermissionManager::getInstance()->isAdminOfServer($server->id())) {
?>
					<li><a href="?page=server&amp;sid=<?php echo $server->id(); ?>"><?php echo $server->id().': '.SettingsManager::getInstance()->getServerName($server->id()); ?></a></li>
<?php
				}
			}
?>
		</ul>
<?php
	} else {
		$_GET['sid'] = intval($_GET['sid']);
		if (!PermissionManager::getInstance()->isAdminOfServer($_GET['sid'])) {
			echo tr('permission_denied');
			MessageManager::echoAllMessages();
			exit();
		}
		$server = ServerInterface::getInstance()->getServer($_GET['sid']);
?>
	<h1>Server Details: <?php echo SettingsManager::getInstance()->getServerName($_GET['sid']); ?></h1>
	<ul>
<?php
		echo sprintf('<li><a class="jqlink" onclick="jq_server_getOnlineUsers(%d); return false;">Online Users</a></li>', $server->id());
		if (PermissionManager::getInstance()->serverCanViewRegistrations($server->id()))
			echo sprintf('<li><a class="jqlink" onclick="jq_server_getRegistrations(%d); return false;">Registrations</a></li>', $server->id());
		echo sprintf('<li><a class="jqlink" onclick="jq_server_getBans(%d); return false;">Bans</a></li>', $server->id());
		echo sprintf('<li><a class="jqlink" onclick="jq_server_showTree(%d); return false;">Channel-Tree</a></li>', $server->id());
		if (PermissionManager::getInstance()->serverCanGenSuUsPW($server->id()))
			echo sprintf('<li id="li_server_superuserpassword"><a class="jqlink" onclick="if(confirm(\'Are you sure you want to generate and set a new SuperUser password?\')){jq_server_setSuperuserPassword(%d); return false;}">Generate new SuperuserPassword</a><div class="ajax_info"></div></li>', $server->id());
		if (PermissionManager::getInstance()->serverCanEditConf($server->id()))
			echo sprintf('<li><a class="jqlink" onclick="jq_server_config_show(%d); return false;">Config</a></li>', $server->id());
?>
	</ul>

	<hr/>

	<div id="jq_information" style="display:none;">

	</div>
	<script type="text/javascript">
		/*<![CDATA[*/
			function randomString(length)
			{
				var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz§$%&/()=?!{[]}";
				var str = '';
				for (i=0; i < length; i++) {
					var r = Math.floor(Math.random() * chars.length);
					str += chars.substring(r, r+1);
				}
				return str;
			}
			function jq_server_setSuperuserPassword(sid)
			{
				$('#li_server_superuserpassword > .ajax_info').html(imgAjaxLoading);
				var pw = randomString(6);
				$.post('./?ajax=server_setSuperuserPassword',
						{ 'sid': <?php echo $_GET['sid']; ?>, 'pw': pw },
						function (data) {
							if (data=='') {
								$('#li_server_superuserpassword > .ajax_info').html('<div>Password set to: '+pw+'</div>');
							} else {
								$('#li_server_superuserpassword > .ajax_info').html(data);
							}
						}
					);
			}
			function jq_server_getRegistrations(sid)
			{
				if (sid==null) {
					sid = <?php echo isset($_GET['sid'])?$_GET['sid']:0; ?>;
				}
				$.post("./?ajax=server_getRegistrations",
						{ 'sid': sid },
						function (data) {
							$('#jq_information').show().html(data);
							<?php if (PermissionManager::getInstance()->serverCanEditRegistrations($_GET['sid'])) { ?>
								$('#jq_information').prepend('<p style="font-size:x-small;">(Double-click entries to edit them)</p>');
								$('.jq_editable').editable(
																						{	'submit': 'save',
																							'cancel':'cancel',
																							'editBy': 'dblclick',
																							'onSubmit':
																								function (content) {
																									var domId = $(this).attr('id');
																									var sub = domId.substring(0, domId.lastIndexOf('_'));
																									var id = domId.substring(domId.lastIndexOf('_')+1);
																									if (id == 0) {
																										alert('Changing the superuser account is not possible.');
																										jq_server_getRegistrations(sid);
																										return;
																									}
																									switch (sub) {
																										case 'user_name':
																											jq_user_updateUsername(id, content.current);
																											break;
																										case 'user_email':
																											jq_user_updateEmail(id, content.current);
																											break;
																										case 'user_hash':
																											jq_user_updateHash(id, content.current);
																											break;
																									}
																								}
																						}
																					);
							<?php } ?>
						}
					);
			}
			function jq_server_registration_remove(uid)
			{
				$.post(
							"./?ajax=server_regstration_remove",
							{ 'sid': <?php echo $_GET['sid']; ?>, 'uid': uid },
							function(data) {
								if (data.length>0) {
									alert('failed: '+data);
								}
								jq_server_getRegistrations(<?php echo $_GET['sid']; ?>);
							}
				);
			}
			function jq_server_user_genNewPw(serverId, userId)
			{
				var newPw = randomString(6);
				$.post(
							"./?ajax=server_regstration_genpw",
							{ 'serverId': serverId, 'userId': userId, 'newPw': newPw },
							function(data) {
								if (data.length>0) {
									alert('failed: '+data);
								} else {
									alert('Password set to: ' + newPw);
								}
								jq_server_getRegistrations(serverId);
							}
				);
			}
			function jq_user_updateUsername(uid, newVal)
			{
				$('#user_name_'+uid).append(imgAjaxLoading);
				var serverId = <?php echo $_GET['sid']; ?>;
				$.post("./?ajax=server_user_updateUsername",
						{ 'sid': serverId, 'uid': uid, 'newValue': newVal },
						function (data) {
							if (data.length>0) { alert('failed: '+data); }
							jq_server_getRegistrations(serverId);
						}
					);
			}
			function jq_user_updateEmail(uid, newVal)
			{
				$('#user_name_'+uid).append(imgAjaxLoading);
				$.post("./?ajax=server_user_updateEmail",
						{ 'sid': <?php echo $_GET['sid']; ?>, 'uid': uid, 'newValue': newVal },
						function (data) {
							if (data.length>0) { alert('failed: '+data); }
							jq_server_getRegistrations();
						}
					);
			}
			function jq_user_updateHash(uid, newVal)
			{
				$('#user_name_'+uid).append(imgAjaxLoading);
				$.post("./?ajax=server_user_updateHash",
						{ 'sid': <?php echo $_GET['sid']; ?>, 'uid': uid, 'newValue': newVal },
						function (data) {
							if (data.length>0) { alert('failed: '+data); }
							jq_server_getRegistrations();
						}
					);
			}
			function jq_user_updateComment(serverId, userId, newVal)
			{
				$.post("./?ajax=server_user_updateComment",
						{ 'sid': serverId, 'uid': userId, 'newValue': newVal },
						function (data) {
							if (data.length>0) { alert('failed: '+data); }
							jq_server_getRegistrations();
						}
					);
			}
			function jq_user_updateAvatar(serverId, userId, newVal)
			{
				$.post("./?ajax=server_user_updateAvatar",
						{ 'sid': serverId, 'uid': userId, 'newValue': newVal },
						function (data) {
							if (data.length>0) { alert('failed: '+data); }
							jq_server_getRegistrations();
						}
					);
			}

			function jq_server_getOnlineUsers(sid)
			{
				$.post("./?ajax=server_onlineUsers_show",
						{ 'sid': sid },
						function(data){
							$('#jq_information').show().html(data);
						}
					);
			}


			function jq_server_getBans(sid)
			{
				$.post("./?ajax=server_bans_show",
						{ 'sid': sid },
						function(data){
							$('#jq_information').show().html(data);
						}
					);
			}
			function jq_server_showACL(sid, cid)
			{
				$.post("./?ajax=show_acl",
						{ 'sid': sid },
						function(data){
							$('#jq_information').show().html(data);
						}
					);
			}
			function jq_server_showTree(sid)
			{
				$.post("./?ajax=show_tree",
						{ 'sid': sid },
						function(data){
							$('#jq_information').show().html(data);
						}
					);
			}
			function jq_server_config_show(sid)
			{
				$.post("./?ajax=server_config_show",
						{ 'sid': sid },
						function(data){
							$('#jq_information').show().html(data);
						}
					);
			}

			function jq_server_user_mute(sessid)
			{
				$.post("./?ajax=server_user_mute",
						{ 'sid': <?php echo $_GET['sid']; ?>, 'sessid': sessid },
						function(data) {
							if (data.length > 0) {
								alert('Error :' + data);
							}
						  jq_server_getOnlineUsers(<?php echo $_GET['sid']; ?>);
						}
					);
			}
			function jq_server_user_unmute(sessid)
			{
				$.post("./?ajax=server_user_unmute",
						{ 'sid': <?php echo $_GET['sid']; ?>, 'sessid': sessid },
						function(data) {
							if (data.length > 0) {
								alert('Error :' + data);
							}
					  	jq_server_getOnlineUsers(<?php echo $_GET['sid']; ?>);
						}
					);
			}
			function jq_server_user_deaf(sessid)
			{
				$.post("./?ajax=server_user_deaf",
						{ 'sid': <?php echo $_GET['sid']; ?>, 'sessid': sessid },
						function(data) {
							if (data.length > 0) {
								alert('Error :' + data);
							}
							jq_server_getOnlineUsers(<?php echo $_GET['sid']; ?>);
						}
					);
			}
			function jq_server_user_undeaf(sessid)
			{
				$.post("./?ajax=server_user_undeaf",
						{ 'sid': <?php echo $_GET['sid']; ?>, 'sessid': sessid },
						function(data) {
							if (data.length > 0) {
								alert('Error :' + data);
							}
					  	jq_server_getOnlineUsers(<?php echo $_GET['sid']; ?>);
						}
					);
			}
			function jq_server_user_kick(sessid)
			{
				if (!confirm('Are you sure you want to kick this user from the server?')) {
					return;
				} else {
					$.post("./?ajax=server_user_kick",
							{ 'sid': <?php echo $_GET['sid']; ?>, 'sessid': sessid },
							function(data) {
								if (data.length > 0) {
									alert('Error :' + data);
								}
								jq_server_getOnlineUsers(<?php echo $_GET['sid']; ?>);
							}
						);
				}
			}
			function jq_server_unban(serverId, ipAsString, bits, username, hash, reason, start, duration)
			{
				var ip = [];
				if (ipAsString.indexOf('.') != -1) {
					// Convert ipv4 string to ipv6 bytearray
					// ipv4s are put into an ipv4 by preceding 0s and 255; last 4 bytes are the ipv4
					ip = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 255, 255];
					var ipv4 = ipAsString.match(/\d{1,3}/g);
					for (var i in ipv4) {
						var realInt = parseInt(ipv4[i], 10);
						if (isNaN(realInt)) {
							console.log('[M] Error: Could not convert ipv4 string to ipv6 bytearray. Intparsing returned NaN.');
							return;
						}
						ip[ip.length] = realInt;
					}
				}
				else {
					// Convert ipv6 string to ipv6 bytearray
					ip = ipAsString.match(/[0-9a-zA-Z]{2}/g);
					for (i in ip) {
						ip[i] = parseInt('0x' + ip[i]);
					}
					if (ip.length != 16) {
						console.log('[M] Error: Could not convert ipv6 string to ipv6 bytearray. Resulting arraylength is != 16.');
						return;
					}
				}
				$.post(
						"./?ajax=server_unban",
						{ 'serverId': serverId, 'ip': ip, 'bits': bits, 'name': username, 'hash': hash, 'reason': reason, 'start': start, 'duration': duration },
						function(data) {
							if (data.length > 0) {
								alert('Error :' + data);
							}
							jq_server_getBans(serverId);
						}
					);
			}
			function jq_server_ban_show(serverId)
			{
				$.post(
						"./?ajax=server_ban_show",
						{ 'serverId': serverId },
						function(data) {
							$('#jq_information').show().html(data);
						}
					);
			}
			function jq_server_ban(serverId, mask, bits)
			{
				$.post(
						"./?ajax=server_ban",
						{ 'serverId': serverId, 'ipmask': mask, 'bits': bits },
						function(data) {
							if (data.length>0) { alert('failed: '+data); } else {
								jq_server_getBans(serverId);
							}
						}
					);
			}

			function center(object)
			{
				object.style.marginLeft = "-" + parseInt(object.offsetWidth / 2) + "px";
				object.style.marginTop = "-" + parseInt(object.offsetHeight / 2) + "px";
			}
			//$('#jq_information').show().html($(parent).id());
		/*]]>*/
	</script>
<?php } ?>
