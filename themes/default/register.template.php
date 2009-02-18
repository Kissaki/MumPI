<?php include 'header.template.php'; ?>

<?php
	if(isset($_GET['action']) && $_GET['action']='doregister'){
		//TODO: register user to server
		
		echo $txt['doregister_success'];
	}else{
?>

<div id="content">
	<form action="./?section=register&amp;action=doregister" method="post">
		<table>
			<tr>
				<td><?php echo $txt['username']; ?>:</td><td><input type="text" name="name" value="" /></td>
			</tr><tr>
				<td><?php echo $txt['email']; ?>:</td><td><input type="text" name="email" value="" /></td>
			</tr><tr>
				<td><?php echo $txt['password']; ?>:</td><td><input type="text" name="password" id="password" value="" /></td>
			</tr><tr>
				<td><?php echo $txt['password']; ?>:</td><td><input type="text" name="password2" id="password2" value="" /></td>
			</tr>
		</table>
		<input type="submit" value="register" />
	</form>
</div>
<?php } ?>
