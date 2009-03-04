<div id="footer">
	<?php
		echo 'Server Version: '.ServerInterface::getInstance()->getVersion();
		echo '<br/>Script execution time: '.sprintf('%6.3f', (microtime_float()-$m_scriptStart)).'ms | memory peak: '.(memory_get_peak_usage()/1000).' kByte';
	?>
</div>
