<?php
	echo '<h1>Admins</h1>';
	echo '<div id="admins_list"><div style="border-bottom:1px dotted grey;"><a class="jqlink" onclick="jq_admins_list_toggle($(this));" style="display:block;">+</a></div><div>';
	echo '</div></div>';
?>
	<br />
	<a>Add Admin</a>
	
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
		function jq_admins_list_toggle(obj){
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
		function jq_admin_list_edit(id){
			$('#admin_list_'+id+' > td:first').html('<input type="text" value="'+$('#admin_list_'+id+' > td:first').html()+'" /> <a class="jqlink" onclick="jq_admin_update_name('+id+'); $(\'#admins_list a\').click();">update</a>');
			
		}
		function jq_admin_update_name(id){
			$.post("./?ajax=db_admin_update_name",
					{ 'name': $('#admin_list_'+id+' > td:first > input').attr() },
					function(data){
						if(data.length>0){ alert('failed: '+data); }
					}
				);
			
		}
		function jq_admin_add(id){
			$.post("./?ajax=db_admin_add",
					{ 'name': $('#admin_list_'+id+' > td:first > input').attr(), 'pw': pw },
					function(data){
						if(data.length>0){ alert('failed: '+data); }
					}
				);
			
		}
		
	</script>
