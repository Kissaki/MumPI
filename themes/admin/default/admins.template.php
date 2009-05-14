<?php
	echo '<ul>';
	DBManager::getInstance()->
	
	echo '</ul>';
?>
	
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
		function jq_db_admin_add(name, pw){
			$.post("./?ajax=server_regstration_remove",
					{ 'sid': <?php echo $_GET['sid']; ?>, 'uid': uid },
					function(data){
						if(data.length>0){ alert('failed: '+data); }
					}
				);
			jq_server_getRegistrations(<?php echo $_GET['sid']; ?>);
			
		}
		
	</script>
<?php } ?>
