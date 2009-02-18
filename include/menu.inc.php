<?php

function printMenu(){
	?>
<div id="menu">
	<ul>
		<li><?php echo $txt['home']; ?></li>
		<?php
			if(true)	// TODO: check if logged in
				echo '<li>'.$txt['login'].'</li>';
			else
				echo '<li>'.$txt['profile'].'</li><li>'.$txt['']
		?>
	</ul>
</div>
	<?php
}
