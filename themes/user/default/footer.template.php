<div id="logarea">
	<?php
		MessageManager::echoAll();
	?>
</div>
<div id="footer">
	<?php
		printf( tr('info_scriptexecutiontime'), PHPStats::scriptExecTimeGet(), ceil(memory_get_peak_usage()/1000) );
	?>
</div>
<script type="text/javascript">
	/*<![CDATA[*/
			$('.helpicon').each(
					function(i, c) {
						var val = $(this).attr('title');
						if (val != undefined && val != '') {
							$(this).attr('title','')
								.hover(
										function(){
											$(this).html('<div class="helpicon_detail">'+val+'<\/div>');
										},
										function() {
											$(this).html('');
										}
									);
						}
					}
				);
		/*]]>*/
</script>