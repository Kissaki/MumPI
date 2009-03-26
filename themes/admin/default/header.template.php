
<div id="menu">
	<ul>
<?php
		if(!SessionManager::getInstance()->isAdmin()){
?>
			<li<?php if(HelperFunctions::getActivePage()=='login') echo ' class="active"';?>><a href="./?page=login">Login</a></li>
	</ul>
</div>
<?php
		}else{
?>
		<li<?php if(HelperFunctions::getActivePage()=='index') echo ' class="active"';?>><a href="./"><?php echo TranslationManager::getText('home'); ?></a></li>
		<li<?php if(HelperFunctions::getActivePage()=='meta') echo ' class="active"';?>><a href="./?page=meta">Meta</a></li>
		<li<?php if(HelperFunctions::getActivePage()=='server') echo ' class="active"';?>><a href="./?page=server">Server</a></li>
		<li<?php if(HelperFunctions::getActivePage()=='logout') echo ' class="active"';?>><a href="./?page=logout">Logout</a></li>
	</ul>
</div>
<?php /*<div id="interface_update_status" style="background-color:darkgrey; float:right; position:absolute; top:0px; right:0px;">
y
</div>
<script type="text/javascript">
	$(document).ready(function(){
		
		$.getJSON("http://kissaki.clandooc.de/mumble/interfaces/PHP_Interface_RecentVersion.php?jsoncallback=?",
			function(data){
				alert('yo');
				$('#interface_update_status').html(data.recent_version);
				$.each(data.test, function(i,item){
		            alert(i); alert(item);
		          });
				alert('yo');
			}
		);

	});
</script>*/ ?>
<?php } ?>
