<?php
	if(SessionManager::getInstance()->isAdmin()){
?>
<script type="text/javascript">
	function jq_loadPage(page){
		$.get('./?ajax=getPage&page='+page, {},
				function(data){
					$('#content').html(data);
				}
			);
	}
</script>
<div id="log_area">
<?php MessageManager::echoAll(); ?>
</div>
<div id="footer">
	<?php
		echo 'Server Version: '.ServerInterface::getInstance()->getVersion();
		echo '<br/>Script execution time: '.sprintf('%6.3f', PHPStats::scriptExecTimeGet()).'ms | memory peak: '.(memory_get_peak_usage()/1000).' kByte';
	?>
</div>
<?php } ?>