
	<h1>Server List</h1>
	<table style="margin-bottom:8px;">
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
				foreach ($servers AS $server) {
					$servername = SettingsManager::getInstance()->getServerName($server->id());
					$server_isRunning = $server->isRunning();
			?>
					<tr class="jqserver" id="jq_server_<?php echo $server->id(); ?>">
						<td><?php echo $server->id(); ?></td>
						<td>
							<?php if (PermissionManager::getInstance()->serverCanEditConf($server->id())) { ?>
								<div class="js_link" style="float:right; margin-right:0px;">
									<a class="jqlink" onclick="jq_meta_server_information_edit(<?php echo $server->id(); ?>)"><img src="<?php echo SettingsManager::getInstance()->getThemeUrl(); ?>/img/server_edit.png" alt="edit" style="width:12px;" /></a>
								</div>
							<?php } ?>
<?php
							if (isset($servername)) {
								echo $servername;
							}
?>
						</td>
						<td>
							<?php
								if ($server_isRunning) {
									echo '<span style="color:green;">Running</span>';
								} else {
									echo '<span style="color:darkgrey;">Not Running</span>';
								}
							?>
						</td>
						<td>
							<?php if (PermissionManager::getInstance()->serverCanStartStop($server->id())) { ?>
								<?php if ($server_isRunning) { ?>
									<a class="jqlink" onclick="if(confirm('Are you sure you want to stop this virtual server?')){jq_server_stop(<?php echo $server->id(); ?>);}" title="Stop Server"><img src="<?php echo SettingsManager::getInstance()->getThemeUrl(); ?>/img/server_stop.png" alt="Stop" /></a>
								<?php } else { ?>
									<a class="jqlink" onclick="jq_server_start(<?php echo $server->id(); ?>)" title="Start Server"><img src="<?php echo SettingsManager::getInstance()->getThemeUrl(); ?>/img/server_start.png" alt="Start" /></a>
								<?php } ?>
							<?php } ?>
							<?php if (PermissionManager::getInstance()->isGlobalAdmin()) { ?>
								<a class="jqlink" onclick="if(confirm('Are you sure you want to delete this Server?\nYou will loose ALL DATA!')){jq_server_delete(<?php echo $server->id(); ?>);} return false;" title="Delete Server"><img src="<?php echo SettingsManager::getInstance()->getThemeUrl(); ?>/img/server_delete.png" alt="Delete" /></a>
							<?php } ?>
						</td>
						<td style="padding-left:10px;">
							<a class="mpi_tooltip" href="?page=server&amp;sid=<?php echo $server->id(); ?>" title="Show Server Details"><img src="<?php echo SettingsManager::getInstance()->getThemeUrl(); ?>/img/server_details.png" alt="Show Server Details" /></a>

						</td>
					</tr><?php
				} ?>
		</tbody>
	</table>

	<?php if (PermissionManager::getInstance()->isGlobalAdmin()) { ?>
		<a class="jqlink mpi_tooltip" id="server_create" title="Create a new Server"><img src="<?php echo SettingsManager::getInstance()->getThemeUrl(); ?>/img/server_create.png" alt="Create a new Server" /></a><br/>
		<a class="jqlink" onclick="jq_meta_showDefaultConfig()">Show Default Config</a>
	<?php } ?>

	<div id="jq_information">

	</div>
	<script type="text/javascript">/*<![CDATA[*/
		$('#server_create').click(
			function(event){
				// send ajax call for creating a server; returns the new servers ID
				$.get("./?ajax=server_create",
					function(data) {
						// reload content (serverlist)
						var newServerId = new Number(data);
						if (isNaN(newServerId)) {
							alert('Error returned: ' + data);
						} else {
							$('#jq_information').html('Server created with ID: ' + data);
							jq_loadPage('meta');
						}
					}
				);
			});

		function jq_server_delete(sid){
			$.post("./?ajax=server_delete",
					{ 'sid': sid },
					function(data){
						if (data.length > 0) {
							// error:
							$('#jq_information').html(data);
						} else {
							$('#jq_information').html('stopped');
							jq_loadPage('meta');
						}
					}
				);
		}
		function jq_server_stop(sid){
			$.post("./?ajax=server_stop",
					{ 'sid': sid },
					function(data){
						if (data.length > 0) {
							// error:
							$('#jq_information').html(data);
						} else {
							$('#jq_information').html('stopped virtual server…');
							jq_loadPage('meta');
						}
					}
				);
		}
		function jq_server_start(sid){
			$.post("./?ajax=server_start",
					{ 'sid': sid },
					function(data){
						if (data.length > 0) {
							// error:
							$('#jq_information').html(data);
						} else {
							$('#jq_information').html('started virtual server…');
							jq_loadPage('meta');
						}
					}
				);
			jq_loadPage('meta');
		}

		function jq_meta_showDefaultConfig(){
			$.post("./?ajax=meta_showDefaultConfig",
					{  },
					function(data){
						$('#jq_information').html('<h2>Default Config</h2>'+data);
					}
				);
		}

		function jq_meta_server_information_edit(serverid)
		{
			$.post(".?ajax=meta_server_information_edit",
					{ 'serverid': serverid },
					function(data){
						$('#jq_information').html(data);
					}
				);
		}
		function jq_meta_server_information_update(serverid)
		{
			$.post(".?ajax=meta_server_information_update",
					{
						'serverid'			: serverid,
						'name'				: $('#meta_server_information_name').attr('value'),
						'allowlogin'		: $('#meta_server_information_allowlogin').attr('checked'),
						'allowregistration' : $('#meta_server_information_allowregistration').attr('checked'),
						'forcemail'			: $('#meta_server_information_forcemail').attr('checked'),
						'authbymail'		: $('#meta_server_information_authbymail').attr('checked')
					},
					function(data)
					{
						if (data > 0) {
							$('#jq_information').html(data);
						} else {
							jq_loadPage('meta');
						}
					}
				);
		}

		function center(object)
		{
			object.style.marginLeft = "-" + parseInt(object.offsetWidth / 2) + "px";
			object.style.marginTop = "-" + parseInt(object.offsetHeight / 2) + "px";
		}
		//$('#jq_information').html($(parent).id());
		/*]]>*/
	</script>
