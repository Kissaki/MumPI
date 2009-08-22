
	<h1>Admins</h1>
	<div id="admins_list">
	 	<div style="border-bottom:1px dotted grey;">
			<a class="jqlink" onclick="jq_admins_list_toggle($(this));" style="display:block;">+</a>
		</div>
		<div>
		</div>
	</div>
	<br/>
	<a class="jqlink" onclick="jq_admin_add_display();">Add Admin</a>
	
	<hr/>
	
	<div id="jq_information">
	</div>
	
	<script type="text/javascript">
		function randomString(length)
		{
			var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz§$%&/()=?!{[]}";
			var str = '';
			for (var i=0; i<length; i++) {
				var r = Math.floor(Math.random() * chars.length);
				str += chars.substring(r,r+1);
			}
			return str;
		}
		function jq_admins_list_toggle(obj)
		{
			if( obj.html() == '+' )
			{
				obj.html('-');
				$.post("./?ajax=db_admins_echo",
						{  },
						function(data){
							$('#admins_list > div:last').html(data);
						}
					);
			}else{
				obj.html('+');
				$('#admins_list > div:last').html('');
			}
		}
		function jq_admin_list_edit(id)
		{
			$('#admin_list_'+id+' > td:first').html('<input type="text" value="'+$('#admin_list_'+id+' > td:first').html()+'" /> <a class="jqlink" onclick="jq_admin_update_name('+id+'); $(\'#admins_list a\').click();">update</a>');
			
		}
		function jq_admin_update_name(id)
		{
			$.post("./?ajax=db_admin_update_name",
					{ 'name': $('#admin_list_'+id+' > td:first > input').attr() },
					function(data){
						if(data.length>0){ alert('failed: '+data); }
					}
				);
			
		}
		function jq_admin_add_display()
		{
			$('#jq_information').html(
					'Name: <input type="text" name="name"/>'
					+ 'Pass: <input type="text" name="pw"/>'
					+ 'is global admin?: <input type="checkbox" name="isGlobalAdmin"/><br/>'
					+ '<input type="submit" onclick="jq_admin_add()" value="Add"/>'
					+ '<input type="button" onclick="$(\'#jq_information\').html(\'\')" value="Cancel"/>'
				);
		}
		function jq_admin_add()
		{
			var name = $('input[name=\'name\']').val();
			var pw = $('input[name=\'pw\']').val();
			var isGlobalAdmin = $('input:checkbox[name=\'isGlobalAdmin\']').attr('checked');
			
			$.post("./?ajax=db_admin_add",
					{ 'name': name, 'pw': pw, 'isGlobalAdmin' : isGlobalAdmin },
					function(data)
					{
						if (data.length>0) {
							$('#jq_information').html('Failed: '+ data);
						} else {
							$('#jq_information').html(
									'Admin account ' + name + ' created'
									+ (isGlobalAdmin ? ' as global admin' : '')
									+ '.'
								);
						}
					}
				);
			$.post("./?ajax=db_admins_echo",
					{  },
					function(data)
					{
						$('#admins_list > div:last').html(data);
					}
				);
		}
		function jq_admin_remove(id)
		{
			$.post("./?ajax=db_admin_remove",
					{ 'id': id },
					function(data)
					{
						if (data.length>0) {
							$('#jq_information').html('Failed: '+data);
						} else {
							$('#jq_information').html('Admin account removed.');
						}
					}
				);
			$.post("./?ajax=db_admins_echo",
					{  },
					function(data){
						$('#admins_list > div:last').html(data);
					}
				);
		}
		
	</script>
