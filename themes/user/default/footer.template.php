<div id="logarea">
<?php
	MessageManager::echoAll();
?>
</div>
<div id="footer">
	<?php
		printf( tr('info_serverversion'), ServerInterface::getInstance()->getVersion() );
		echo '<br/>';
		printf( tr('info_scriptexecutiontime'), PHPStats::scriptExecTimeGet(), ceil(memory_get_peak_usage()/1000) );
	?>
</div>
