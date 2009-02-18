<?php
class TemplateParser{
	function parse($file){
		if(!file_exists($file))
			return;
		$fh = fopen($file, 'r');
		while($str = fgets($fh)){
			
		}
	}
}
?>