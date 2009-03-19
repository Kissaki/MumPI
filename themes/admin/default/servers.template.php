<?php
	if(isset($_GET['action'])){
		switch($_GET['action']){
			
		}
	}
?>
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
						<td><?php
							if(isset($servername)){
								echo $servername;
							} ?>
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
							<a class="jqlink" onclick="jq_server_getRegistrations(<?php echo $server->id(); ?>); return false;" href="./?page=users">Show Users</a>
						</td>
					</tr><?php
				} ?>
		</tbody>
	</table>
	
	<a>Delete</a>
	<a>Show Channels</a>
	<a>Show ACLs</a>
	
	<a class="jqlink" id="server_create">Create a new Server</a>
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
				jq_loadPage('servers');
			});
		function jq_loadPage(page){
			$.get('./?ajax=getPage&page='+page, {},
					function(data){
						$('#content').html(data);
					}
				);
		}
		function jq_server_stop(sid){
			$.post("./?ajax=server_stop",
					{ 'sid': sid },
					function(data){
						$('#jq_information').show().html('stopped');
					}
				);
			jq_loadPage('servers');
		}
		function jq_server_start(sid){
			$.post("./?ajax=server_start",
					{ 'sid': sid },
					function(data){
						$('#jq_information').show().html('stopped');
					}
				);
			jq_loadPage('servers');
		}
		function jq_server_getRegistrations(sid){
			$.post("./?ajax=server_getRegistrations",
					{ 'sid': sid },
					function(data){
						$('body').append(data);
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
