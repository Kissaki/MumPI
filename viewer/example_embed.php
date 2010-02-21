You probably want to embed it via HTML.<br/>
See <a href="./example_embed.html">example_embed.html</a><br/>
The PHP inclusion is not that far yet (only useful if you know what you’re doing and want to pull data yourself or just once).<br/>
<br/>
Pull once:<br/>
<?php
	define('MUMPHPI_MAINDIR', '..');
	define('MUMPHPI_SECTION', 'viewer');
	require_once(MUMPHPI_MAINDIR.'/classes/ServerViewer.php');
	
	echo ServerViewer::getHtmlCode4ViewServer(1);
?>
<textarea rows="7" cols="90">
&lt;?php
	define('MUMPHPI_MAINDIR', '..');
	define('MUMPHPI_SECTION', 'viewer');
	require_once(MUMPHPI_MAINDIR.'/classes/ServerViewer.php');
	
	echo ServerViewer::getHtmlCode4ViewServer($serverId);
?&gt;
</textarea>