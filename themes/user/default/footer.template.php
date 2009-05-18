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
	var helpicons = $('.helpicon');
	for( var val in helpicons )
	{
		
	}
	$('.helpicon').each(function(i,c){
		var val = $(this).attr('title');
		if( val != undefined && val != '' ){
			$(this).hover(function(){
					$(this).append('<div style="position:absolute; border:1px solid #844; background-color:#444; margin-left:24px; margin-top:4px;">'+val+'</div>');
				}, function(){
					$(this).html('');
				});
		}
	});
</script>