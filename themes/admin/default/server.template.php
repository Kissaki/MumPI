<?php
	if(!isset($_GET['sid']) || empty($_GET['sid'])){
		$servers = ServerInterface::getInstance()->getServers();
?>
		<h1>Select a server</h1>
		<ul>
<?php		foreach($servers AS $server){	?>
				<li><a href="?page=server&amp;sid=<?php echo $server->id(); ?>"><?php echo $server->id().': '.SettingsManager::getInstance()->getServerName($server->id()); ?></a></li>
<?php		}	?>
		</ul>
<?php
	}else{
		$_GET['sid'] = intval($_GET['sid']);
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
		echo sprintf('<li><a class="jqlink" onclick="jq_server_config_show(%d); return false;">Config</a></li>', $server->id());
?>
	</ul>
	
	<hr/>
	
	<div id="jq_information" style="display:none;">
		
	</div>
	<script type="text/javascript">
		function randomString(length) {
			var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz§$%&/()=?!{[]}";
			var str = '';
			for (var i=0; i<length; i++) {
				var r = Math.floor(Math.random() * chars.length);
				str += chars.substring(r,r+1);
			}
			return str;
		}
		function jq_server_setSuperuserPassword(sid)
		{
			$('#li_server_superuserpassword > .ajax_info').html('<img src="<?php echo SettingsManager::getInstance()->getThemeUrl(); ?>/img/ajax-loader.gif" alt="loading…"/>');
			var pw = randomString(6);
			$.post('./?ajax=server_setSuperuserPassword',
					{ 'sid': <?php echo $_GET['sid']; ?>, 'pw': pw },
					function(data)
					{
						if(data=='')
						{
							$('#li_server_superuserpassword > .ajax_info').html('<div>Password set to: '+pw+'</div>');
						}else{
							$('#li_server_superuserpassword > .ajax_info').html(data);
						}
					}
				);
		}
		function jq_updateUsername(uid, newValue){
			$.post('./?ajax=server_user_updateUsername',
					{ 'sid': <?php echo $_GET['sid']; ?>, 'uid': newValue }
				);
		}
		function jq_server_getRegistrations(sid){
			$.post("./?ajax=server_getRegistrations",
					{ 'sid': sid },
					function(data){
						$('#jq_information').show().html(data).prepend('<p style="font-size:x-small;">(Double-click entries to edit them)</p>');
						$('.jq_editable')
							.editable(
								{	'submit': 'save',
									'cancel':'cancel',
									'editBy': 'dblclick',
									'onSubmit':
										function(content)
										{
											var id = $(this).attr('id');
											var sub = id.substring(0, id.lastIndexOf('_'));
											var id = id.substring(id.lastIndexOf('_')+1, id.length);
											if(id==0)
											{
												alert('Changing the superuser account is not possible.');
												jq_server_getRegistrations(sid);
												return;
											}
											switch(sub){
												case 'user_name':
													jq_user_updateUsername(id, content.current);
													break;
												case 'user_email':
													jq_user_updateEmail(id, content.current);
													break;
											}
										}
								}
							);
					}
				);
		}
		function jq_server_registration_remove(uid){
			$.post("./?ajax=server_regstration_remove",
					{ 'sid': <?php echo $_GET['sid']; ?>, 'uid': uid },
					function(data){
						if(data.length>0){ alert('failed: '+data); }
					}
				);
			jq_server_getRegistrations(<?php echo $_GET['sid']; ?>);
			
		}
		function jq_user_updateUsername(uid, newVal){
			$.post("./?ajax=server_user_updateUsername",
					{ 'sid': <?php echo $_GET['sid']; ?>, 'uid': uid, 'newValue': newVal },
					function(data){
						if(data.length>0){ alert('failed: '+data); }
					}
				);
		}
		function jq_user_updateEmail(uid, newVal){
			$.post("./?ajax=server_user_updateEmail",
					{ 'sid': <?php echo $_GET['sid']; ?>, 'uid': uid, 'newValue': newVal },
					function(data){
						if(data.length>0){ alert('failed: '+data); }
					}
				);
		}

		function jq_server_getOnlineUsers(sid){
			$.post("./?ajax=show_onlineUsers",
					{ 'sid': sid },
					function(data){
						$('#jq_information').show().html(data);
					}
				);
		}
		

		function jq_server_getBans(sid){
			$.post("./?ajax=show_server_bans",
					{ 'sid': sid },
					function(data){
						$('#jq_information').show().html(data);
					}
				);
		}
		function jq_server_showACL(sid, cid){
			$.post("./?ajax=show_acl",
					{ 'sid': sid },
					function(data){
						$('#jq_information').show().html(data);
					}
				);
		}
		function jq_server_showTree(sid){
			$.post("./?ajax=show_tree",
					{ 'sid': sid },
					function(data){
						$('#jq_information').show().html(data);
					}
				);
		}
		function jq_server_config_show(sid){
			$.post("./?ajax=server_config_show",
					{ 'sid': sid },
					function(data){
						$('#jq_information').show().html(data);
					}
				);
		}
		
		function jq_server_user_mute(sessid){
			$.post("./?ajax=server_user_mute",
					{ 'sid': <?php echo $_GET['sid']; ?>, 'sessid': sessid }
				);
			jq_server_getOnlineUsers(<?php echo $_GET['sid']; ?>);
		}
		function jq_server_user_unmute(sessid){
			$.post("./?ajax=server_user_unmute",
					{ 'sid': <?php echo $_GET['sid']; ?>, 'sessid': sessid }
				);
			jq_server_getOnlineUsers(<?php echo $_GET['sid']; ?>);
		}
		function jq_server_user_deaf(sessid){
			$.post("./?ajax=server_user_deaf",
					{ 'sid': <?php echo $_GET['sid']; ?>, 'sessid': sessid }
				);
			jq_server_getOnlineUsers(<?php echo $_GET['sid']; ?>);
		}
		function jq_server_user_undeaf(sessid){
			$.post("./?ajax=server_user_undeaf",
					{ 'sid': <?php echo $_GET['sid']; ?>, 'sessid': sessid }
				);
			jq_server_getOnlineUsers(<?php echo $_GET['sid']; ?>);
		}
		function jq_server_user_kick(sessid){
			if(!confirm('Are you sure you want to kick this user from the server?'))
				return;
			$.post("./?ajax=server_user_kick",
					{ 'sid': <?php echo $_GET['sid']; ?>, 'sessid': sessid }
				);
			jq_server_getOnlineUsers(<?php echo $_GET['sid']; ?>);
		}
		function jq_server_user_ban(sessid){
			if(!confirm('Are you sure you want to ban and kick this user from the server?'))
				return;
			$.post("./?ajax=server_user_ban",
					{ 'sid': <?php echo $_GET['sid']; ?>, 'sessid': sessid },
					function(data)
					{
						if(data.length>0)
							alert(data);
					}
				);
			jq_server_getOnlineUsers(<?php echo $_GET['sid']; ?>);
		}
		function jq_server_unban(serverId, mask, bits)
		{
			$.post(
					"./?ajax=server_unban",
					{ 'serverId': serverId, 'ipmask': mask, 'bits': bits },
					function(data) {
						if(data.length>0){ alert('failed: '+data); }
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
						if(data.length>0){ alert('failed: '+data); } else {
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
	</script>
<?php } ?>
