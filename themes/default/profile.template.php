<?php
//TODO: implement javascript version of form

if(isset($_GET['action']) && $_GET['action']=='doedit'){
	// login check
	if(!isset($_SESSION['userid'])) die();
	
	// new password
	if(isset($_POST['password'])){
		if(empty($_POST['password']))
			echo 'Password field was empty. Sending you back...<br/>';
		else
			ServerDatabase::getInstance()->updateUserPw($_SESSION['serverid'], $_SESSION['userid'], $_POST['password']);
	}
	// new username
	if(isset($_POST['name'])){
		ServerDatabase::getInstance()->updateUserName($_SESSION['serverid'], $_SESSION['userid'], $_POST['name']);
	}
	// new email
	if(isset($_POST['email'])){
		ServerDatabase::getInstance()->updateUserEmail($_SESSION['serverid'], $_SESSION['userid'], $_POST['email']);
	}
}

?>
<h1>Edit Profile</h1>
<form action="?section=profile&amp;action=doedit" method="post">
	<table>
		<tr><?php // SERVER Information (not changeable) ?>
			<td class="formitemname"><?php echo $txt['server']; ?>:</td>
			<td>
				<?php
					echo SettingsManager::getInstance()->getServerName($_SESSION['serverid']);
				?>
			</td>
			<td></td>
		</tr>
		<tr><?php // USERNAME ?>
			<td class="formitemname"><?php echo $txt['username']; ?>:</td>
			<td><?php
				if(isset($_GET['action']) && $_GET['action']=='edit_uname'){
					?><input type="text" name="name" value="<?php echo ServerDatabase::getInstance()->getUsername($_SESSION['serverid'], $_SESSION['userid']); ?>" /><?php
				}else{
					echo ServerDatabase::getInstance()->getUsername($_SESSION['serverid'], $_SESSION['userid']);
				} ?></td>
			<td>
				<a href="?section=profile&amp;action=edit_uname" id="profile_uname_edit"<?php if(isset($_GET['action']) && $_GET['action']=='edit_uname'){ echo 'class="hidden"'; } ?>>edit</a>
				<?php if(isset($_GET['action']) && $_GET['action']=='edit_uname'){ echo '<input type="submit" value="update"/>'; } ?><a href="?section=profile&amp;action=doedit_uname" id="profile_uname_update" class="hidden">update</a>
				<a href="?section=profile" id="profile_uname_cancel"<?php if(!isset($_GET['action']) || $_GET['action']!='edit_uname'){ ?> class="hidden"<?php } ?>>cancel</a>
			</td>
		</tr>
		<tr><?php // PASSWORD ?>
			<td class="formitemname"><?php echo $txt['newpassword']; ?>:</td>
			<td><?php if(isset($_GET['action']) && $_GET['action']=='edit_pw'){ ?><input type="text" name="password" id="password" value="" /><?php }else{ echo '<span class="info" title="password is not displayed">*****</span>'; } ?></td>
			<td>
				<a href="?section=profile&amp;action=edit_pw" id="profile_pw_edit"<?php if(isset($_GET['action']) && $_GET['action']=='edit_pw'){ ?> class="hidden"<?php } ?>>edit</a>
				<?php if(isset($_GET['action']) && $_GET['action']=='edit_pw'){ echo '<input type="submit" value="update"/>'; } ?><a id="profile_pw_update" class="hidden">update</a>
				<a href="?section=profile" id="profile_pw_cancel"<?php if(!isset($_GET['action']) || $_GET['action']!='edit_pw'){ ?> class="hidden"<?php } ?>>cancel</a></td>
		</tr>
		<tr><?php // E-MAIL ?>
			<td class="formitemname"><?php echo $txt['newemail']; ?>:</td>
			<td><?php
				if(isset($_GET['action']) && $_GET['action']=='edit_email'){
					?><input type="text" name="email" id="email" value="<?php echo ServerDatabase::getInstance()->getUserEmail($_SESSION['serverid'], $_SESSION['userid']); ?>" /><?php
				}else{
					echo ServerDatabase::getInstance()->getUserEmail($_SESSION['serverid'], $_SESSION['userid']);
				}
			?></td>
			<td>
				<a href="?section=profile&amp;action=edit_email" id="profile_email_edit"<?php if(isset($_GET['action']) && $_GET['action']=='edit_email'){ ?> class="hidden"<?php } ?>>edit</a>
				<?php if(isset($_GET['action']) && $_GET['action']=='edit_email'){ echo '<input type="submit" value="update"/>'; } ?><a id="profile_email_update" class="hidden">update</a>
				<a href="?section=profile" id="profile_email_cancel"<?php if(!isset($_GET['action']) || $_GET['action']!='edit_email'){ ?> class="hidden"<?php } ?>>cancel</a></td>
		</tr>
	</table>
	<script type="text/javascript">
		$('#profile_uname_edit').click( function(event){
			$('#profile_uname_*').toggle( function(){$(this).removeClass('hidden');}, function(){$(this).addClass('hidden');} );
		} );
	</script>
</form>
