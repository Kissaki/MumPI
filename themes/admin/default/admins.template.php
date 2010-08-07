
	<h1>Admins, Groups and Permissions</h1>

<?php /* TODO: tab-ize page */ ?>

	<div id="admin_area">
		<div id="admins_list" class="datalist">
			<h2>Admin Accounts</h2>
		 	<div class="head">
				<a class="jqlink" onclick="jq_admins_list_toggle();" style="display:block;">
					<span class="indicator" style="float:left; width:16px; text-decoration:none;">+</span> Admins
				</a>
			</div>
			<div class="content"></div>
		</div>
		<p><a class="jqlink" onclick="jq_admin_add_display();">Add Admin</a></p>
		<div class="content"></div>
	</div>
	<br/>

	<div id="adminGroups">
		<h2>Admin Groups</h2>
		<div class="datalist">
			<div class="head">
				<a class="jqlink" onclick="jq_adminGroups_list_toggle();" style="display:block;">
					<span class="indicator">+</span> Admin Groups
				</a>
			</div>
			<div class="content"></div>
		</div>
		<p><a class="jqlink" onclick="jq_admingroup_add_display();">Add Admin Group</a></p>
	</div>
	<br/>

	<hr/>

	<div id="jq_information"></div>

	<script type="text/javascript">
		//<![CDATA[
		var admins_list_expanded = false;
		var adminGroups_list_expanded = false;

		function randomString(length)
		{
			var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz§$%&/()=?!{[]}";
			var str = '';
			for (i = 0; i < length; i++) {
				var r = Math.floor(Math.random() * chars.length);
				str += chars.substring(r, r+1);
			}
			return str;
		}

		/********************************************************************
		/* Admins
		/********************************************************************/

		function jq_admins_list_display()
		{
			$.post("./?ajax=db_admins_echo",
					{  },
					function(data){
						$('#admins_list > div.content').html(data);
					}
				);
		}

		function jq_admins_list_toggle()
		{
			if (!admins_list_expanded) {
				window.location.hash = 'admins';
				$('#admins_list > div.head > a > .indicator').html('-');
				jq_admins_list_display();
				admins_list_expanded = true;
			} else {
				window.location.hash = '';
				<?php // TODO: a refresh link would be useful ?>
				$('#admins_list > div.head > a > .indicator').html('+');
				$('#admins_list > div.content').html('');
				admins_list_expanded = false;
			}
		}

		function jq_admin_update_name(id)
		{
			$.post("./?ajax=db_admin_update_name",
					{ 'name': $('#admin_list_'+id+' > td:first > input').attr() },
					function(data) {
						if (data.length>0) { alert('failed: '+data); }
					}
				);
		}

		function jq_admin_add_display()
		{
			$('#admin_area > div.content').html(
					'<div class="admin_add_form">'
					+ 'Name: <input type="text" name="name"/>'
					+ 'Pass: <input type="text" name="pw"/>'
					+ 'is global admin?: <input type="checkbox" name="isGlobalAdmin"/><br/>'
					+ '<input type="submit" onclick="jq_admin_add();" value="Add"/>'
					+ '<input type="button" onclick="$(\'#admin_area > div.content\').html(\'\');" value="Cancel"/>'
					+ ' </div>'
				);
		}

		function jq_admin_add()
		{
			var name = $(".admin_add_form input[name='name']").val();
			var pw = $(".admin_add_form input[name='pw']").val();
			var isGlobalAdmin = $(".admin_add_form input[name='isGlobalAdmin']").attr('checked');

			$.post(
					"./?ajax=db_admin_add",
					{ 'name': name, 'pw': pw, 'isGlobalAdmin': isGlobalAdmin },
					function(data)
					{
						if (data.length>0) {
							$('#admin_area > div.content').html('Failed: '+ data);
						} else {
							$('#admin_area > div.content').html(
									'Admin account ' + name + ' created'
									+ (isGlobalAdmin ? ' as global admin' : '')
									+ '.'
								);
						}
						jq_admins_list_display();
					}
				);
		}

		function jq_admin_remove(id)
		{
			if (!confirm('Are you sure you want to remove this admin account?')) {
				return ;
			}
			$.post("./?ajax=db_admin_remove",
					{ 'id': id },
					function(data)
					{
						if (data.length>0) {
							$('#jq_information').html('Failed: '+data);
						} else {
							$('#jq_information').html('Admin account removed.');
						}
						jq_admins_list_display();
					}
				);
		}


		/********************************************************************
		/* Admin Groups
		/********************************************************************/

		function jq_adminGroups_list_display()
		{
			$.post("./?ajax=db_admingroups_echo",
					{  },
					function(data){
						$('#adminGroups > div.datalist > div.content').html(data);
					}
				);
		}

		function jq_adminGroups_list_toggle()
		{
			if (!adminGroups_list_expanded) {
				window.location.hash = 'showAdminGroups';
				$('#adminGroups > div.datalist > div.head > a > .indicator').html('-');
				jq_adminGroups_list_display();
				/*$.getJSON("./?ajax=db_adminGroupHeads_get",
						function(data){
							$.each(data,
									function(i, item){
										$('#adminGroups > div.content tbody')
											.append('<tr><td>' + item.id + '</td><td>' + item.name + '</td></tr>');
									}
								);

						}
					);*/
				adminGroups_list_expanded = true;
			} else {
				window.location.hash = '';
				$('#adminGroups > div.datalist > div.head > a > .indicator').html('+');
				$('#adminGroups > div.datalist > div.content').html('');
				adminGroups_list_expanded = false;
			}
		}

		function jq_admingroup_add_display()
		{
			$('#jq_information').html(
					  'Name: <input class="admingroup_add_name" type="text"/>'
					+ 'Permissions:'
					+ '<div style="margin-left:6px;">'
						+ '+ add permissions'
					+ '</div>'
					+ '<input type="submit" value="Add Admin Group" onclick="jq_admingroup_add(); return false;" />'
				);
		}

		function jq_admingroup_add()
		{
			var name = $('.admingroup_add_name').attr('value');
			$.post("./?ajax=db_adminGroup_add",
					{ 'name': name },
					function(data)
					{
						if (data.length>0) {
							$('#jq_information').html('Failed: '+ data);
						} else {
							$('#jq_information').html(
									'AdminGroup ' + name + ' created.'
								);
						}
						jq_adminGroups_list_display();
					}
				);

		}

		function jq_admingroup_remove(gid)
		{
			if (!confirm('Are you sure you want to remove this admin group?'))
				return ;
			$.post('./?ajax=db_adminGroup_remove',
					{ 'id': gid },
					function() {
						jq_adminGroups_list_display();
						if (admins_list_expanded) {
							jq_admins_list_display();
						}
					}
				);
		}

		function jq_admingroup_perms_edit_display(gid)
		{
			$.post('./?ajax=db_adminGroup_perms_edit_display', { 'groupID': gid },
					function(data){$('#jq_information').html(data);}
				);
		}

		function jq_admingroup_perm_update(gid, perm, val)
		{
			$.post('./?ajax=db_adminGroup_perm_update', { 'gid': gid, 'perm': perm, 'newval': val },
					function(data)
					{
						if (data.length>0) {
							$('#jq_information').html('Failed: '+ data);
						}
						jq_adminGroups_list_display();
					}
				);
		}

		function jq_admingroup_perms_edit(gid, perms)
		{
			$.post('./?ajax=db_adminGroup_perms_edit', { 'gid': gid, 'perms': perms },
					function(data)
					{
						if (data.length>0) {
							$('#jq_information').html('Failed: '+ data);
						} else {
							$('#jq_information').html(
									'Permissions updated.'
								);
						}
						jq_adminGroups_list_display();
					}
				);
		}

		function jq_admingroup_server_add(groupID, serverID)
		{
			$.post("./?ajax=db_adminGroups_makeAdminOnServer",
					{ 'groupID': groupID, 'serverID': serverID },
					function(data)
					{
						if (data.length>0) {
							$('#jq_information').html('Failed: '+ data);
						}
					}
				);
			jq_adminGroups_list_display();
		}
		function jq_admingroup_server_remove(groupID, serverID)
		{
			$.post("./?ajax=db_adminGroups_revokeAdminOnServer",
					{ 'groupID': groupID, 'serverID': serverID },
					function(data)
					{
						if (data.length>0) {
							$('#jq_information').html('Failed: '+ data);
						}
					}
				);
			jq_adminGroups_list_display();
		}
		function jq_adminGroup_server_update(groupID, serverID, newval)
		{
			if (newval) {
				jq_admingroup_server_add(groupID, serverID);
			} else {
				jq_admingroup_server_remove(groupID, serverID);
			}
			jq_admingroup_server_assoc_edit_display(groupID);
		}
		function jq_admingroup_server_assoc_edit_display(groupID)
		{
			$.post('./?ajax=db_adminGroup_servers_edit_display', { 'groupID': groupID },
					function(data){$('#jq_information').html(data);}
				);
		}


		function jq_admin_addToGroup_display(aid)
		{
			$.post(
					'./?ajax=db_admin_addToGroup_display',
					{ 'aid' : aid },
					function(data)
					{
						$('#admin_area > .content').html(data);
					}
				);
		}

		function jq_admin_addToGroup(aid, gid)
		{
			$.post("./?ajax=db_admin_addToGroup",
					{ 'aid': aid, 'gid': gid },
					function(data)
					{
						if (data.length>0) {
							$('#jq_information').html('Failed: '+ data);
						} else {
							$('#jq_information').html(
									'Added admin to group.'
								);
						}
						jq_admins_list_display();
					}
				);
		}
		function jq_admin_removeFromGroups(adminId)
		{
			$.post("./?ajax=db_admin_removeFromGroups",
					{ 'aid': adminId },
					function(data)
					{
						if (data.length>0) {
							$('#jq_information').html('Failed: '+ data);
						} else {
							$('#jq_information').html(
									'Removed admin from groups.'
								);
						}
						jq_admins_list_display();
					}
				);
		}


		/********************************************************************
		/*** Init
		/********************************************************************/
		$('document').ready(function(){
				if (window.location.hash == '#admins') {
					jq_admins_list_toggle();
				}
				if (window.location.hash == '#showAdminGroups') {
					jq_adminGroups_list_toggle();
				}
				$('#tabs').tabs();
			});
		//]]>
	</script>
