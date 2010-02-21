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
		echo '<div class="">Server Version: '.ServerInterface::getInstance()->getVersion() . '</div>';
		echo '<div class="">Script execution time: '.sprintf('%6.3f', PHPStats::scriptExecTimeGet()).'ms | memory peak: '.(memory_get_peak_usage()/1000).' kByte</div>';
	?>
	<div class="updatecheck_result"></div>
</div>
<?php
		include_once(MUMPHPI_MAINDIR.'/version.php');
		if (isset($mumpiVersion)) {
?>
<script type="text/javascript">
	<!--
		function mumpi_jsonp(data)
		{
			jQuery('.updatecheck_result').html(data);
		}
	-->
</script>
<script type="text/javascript" src="http://mumpi.sourceforge.net/version.php?version=<?php echo $mumpiVersion; ?>"></script>
<?php
		}
	}
?>