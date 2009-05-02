<?php
if(isset($_GET['action']) && $_GET['action'] == 'dologin' ){
	if(isset($_POST['serverid']) && isset($_POST['name']) && $_POST['password']){
		$tmpUid = ServerInterface::getInstance()->verifyPassword($_POST['serverid'],$_POST['name'],$_POST['password']);
		switch($tmpUid){
			case -2:
				echo 'Unknown username.<br/><a onclick="history.go(-1); return false;" href="?page=login">Go back</a> and check your input.<br/>'.
					'If you forgot your login or password, <a href="?page=request">request it</a>.';
					Logger::log_loginFail($_POST['serverid'], $_POST['name'], $_POST['password']);
				break;
			case -1:
				echo 'wrong login information<br/><a onclick="history.go(-1); return false;" href="?page=login">go back</a><br/>'.
					'If you forgot your login or password, <a href="?page=request">request it</a>.';
				break;
			default:	// login success
				$_SESSION['serverid'] = $_POST['serverid'];
				$_SESSION['userid'] = $tmpUid;
				$_SESSION['userLoggedIn'] = true;
				echo '<script type="text/javascript">location.replace("?page=profile")</script>';
				echo 'Login successfull.<br/>
					Go on to the <a href="?page=profile">profile page</a>.';
				break;
		}
	}
}else{
?>

<div id="content">
	<h1><?php TranslationManager::echoText('login_head'); ?></h1>
	<form action="./?page=login&amp;action=dologin" method="post" style="width:400px;">
		<table class="fullwidth">
			<tr>
				<td class="formitemname"><?php echo TranslationManager::getText('server'); ?>:</td>
				<td>
					<?php $servers = SettingsManager::getInstance()->getServers(); ?>
					<select name="serverid">
						<?php
							foreach($servers AS $sid=>$server){
								// Check that server allows login and does exist
								if( $server['allowlogin'] && ServerInterface::getInstance()->getServer($sid)!=null ){
									echo '<option value="'.$sid.'">';
									echo $server['name'];
									echo '</option>';
								}
							}
						?>
					</select>
				</td>
				<td class="helpicon" title="<?php echo TranslationManager::getText('help_login_server'); ?>"></td>
			</tr>
			<tr>
				<td class="formitemname"><?php echo TranslationManager::getText('username'); ?>:</td>
				<td><input type="text" name="name" value="" /></td>
				<td class="helpicon" title="<?php echo TranslationManager::getText('help_login_username'); ?>"></td>
			</tr><tr>
				<td class="formitemname"><?php echo TranslationManager::getText('password'); ?>:</td>
				<td><input type="password" name="password" id="password" value="" /></td>
				<td class="helpicon" title="<?php echo TranslationManager::getText('help_login_password'); ?>"></td>
			</tr>
		</table>
		<div class="alignc" style="margin-top:8px;"><input type="submit" value="<?php TranslationManager::echoText('login_button'); ?>" /></div>
	</form>
	<p style="margin-top:20px;"><?php TranslationManager::echoText('login_requestnote'); ?></p>
</div>
<?php } ?>
