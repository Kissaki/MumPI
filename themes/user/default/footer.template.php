<div id="logarea">
<?php
	MessageManager::echoAll();
?>
</div>
<div id="footer">
	<div style="float:right;"><a href="http://validator.w3.org/check?uri=referer" rel="external"><img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Transitional" height="31" width="88" /></a></div>
	<?php
		printf( tr('info_serverversion'), ServerInterface::getInstance()->getVersion() );
		echo '<br/>';
		printf( tr('info_scriptexecutiontime'), PHPStats::scriptExecTimeGet(), ceil(memory_get_peak_usage()/1000) );
	?>
</div>
<script type="text/javascript">
	$('.helpicon').each(function(i,c){
		var val = $(this).attr('title');
		if( val != undefined && val != '' ){
			$(this).attr('title','')
				.hover(function(){
					$(this).html('<div class="helpicon_detail">'+val+'<\/div>');
					$(this).a
				}, function(){
					$(this).html('');
				});
		}
	});
</script>