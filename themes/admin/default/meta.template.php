
	<h1>Server List</h1>
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Name (in Interface)</th>
				<th>Running?</th>
			</tr>
		</thead>
		<tbody>
			<?php
				$servers = ServerInterface::getInstance()->getServers();
				foreach($servers AS $server){
					$servername = SettingsManager::getInstance()->getServerName($server->id());
					$server_isRunning = $server->isRunning();
			?>
					<tr class="jqserver" id="jq_server_<?php echo $server->id(); ?>">
						<td><?php echo $server->id(); ?></td>
						<td>
							<div class="js_link" style="float:right;">
								<a class="jqlink" onclick="jq_meta_server_information_edit(<?php echo $server->id(); ?>)">edit</a>
							</div>
<?php
							if(isset($servername)){
								echo $servername;
							}
?>
						</td>
						<td>
							<?php
								if($server_isRunning){
									echo '<span style="color:green;">Running</span>';
								}else{
									echo '<span style="color:darkgrey;">Not Running</span>';
								}
							?>
						</td>
						<td>
							<?php if($server_isRunning){?>
								<a class="jqlink" onclick="jq_server_stop(<?php echo $server->id(); ?>)">Stop</a>
							<?php }else{ ?>
								<a class="jqlink" onclick="jq_server_start(<?php echo $server->id(); ?>)">Start</a>
							<?php } ?>
							<a class="jqlink" onclick="jq_server_delete(<?php echo $server->id(); ?>); return false;">Delete</a>
						</td>
						<td style="padding-left:10px;">
							<a href="?page=server&amp;sid=<?php echo $server->id(); ?>">Show Server Details</a> 
							
						</td>
					</tr><?php
				} ?>
		</tbody>
	</table>
	
	
	<a class="jqlink" id="server_create">Create a new Server</a>
	<a class="jqlink" onclick="jq_meta_showDefaultConfig()">Show Default Config</a>
	
	<div id="jq_information" style="display:none;">
		
	</div>
	<script type="text/javascript">
		$('#server_create').click(
			function(event){
				// $.get("./?ajax=server_create", { name: "John", time: "2pm" } );
				$.post("./?ajax=server_create",
					{ name: "John", time: "2pm" },
					function(data){
						$('#jq_information').show().html('Server created with ID: '+data);
					}
				);
				jq_loadPage('meta');
			});
		function jq_loadPage(page){
			$.get('./?ajax=getPage&page='+page, {},
					function(data){
						$('#content').html(data);
					}
				);
		}
		function jq_server_delete(sid){
			$.post("./?ajax=server_delete",
					{ 'sid': sid },
					function(data){
						if(data!=''){
							$('#jq_information').show().html(data);
						}
						$('#jq_information').show().html('stopped');
					}
				);
			jq_loadPage('meta');
		}
		function jq_server_stop(sid){
			$.post("./?ajax=server_stop",
					{ 'sid': sid },
					function(data){
						$('#jq_information').show().html('stopped');
					}
				);
			jq_loadPage('meta');
		}
		function jq_server_start(sid){
			$.post("./?ajax=server_start",
					{ 'sid': sid },
					function(data){
						$('#jq_information').show().html('stopped');
					}
				);
			jq_loadPage('meta');
		}

		function jq_meta_showDefaultConfig(){
			$.post("./?ajax=meta_showDefaultConfig",
					{  },
					function(data){
						$('#jq_information').show().html('<h2>Default Config</h2>'+data);
					}
				);
		}

		function jq_meta_server_information_edit(serverid)
		{
			$.post(".?ajax=meta_server_information_edit",
					{ 'serverid': serverid },
					function(data){
						$('#jq_information').show().html(data);
					}
				);
		}
		function jq_meta_server_information_update(serverid)
		{
			$.post(".?ajax=meta_server_information_update",
					{
						'serverid'			: serverid,
						'name'				: $('#meta_server_information_name').attr('value'),
						'allowlogin'		: $('#meta_server_information_allowlogin').attr('checked')	=='checked',
						'allowregistration' : $('#meta_server_information_allowregistration').attr('checked') =='checked',
						'forcemail'			: $('#meta_server_information_forcemail').attr('checked')	=='checked',
						'authbymail'		: $('#meta_server_information_authbymail').attr('checked')	=='checked'
					},
					function(data){
						$('#jq_information').show().html(data);
					}
				);
			jq_loadPage('meta');
		}
		
		function center(object)
		{
			object.style.marginLeft = "-" + parseInt(object.offsetWidth / 2) + "px";
			object.style.marginTop = "-" + parseInt(object.offsetHeight / 2) + "px";
		}
		//$('#jq_information').show().html($(parent).id());
	</script>
