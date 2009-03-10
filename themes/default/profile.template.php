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
			ServerInterface::getInstance()->updateUserPw($_SESSION['serverid'], $_SESSION['userid'], $_POST['password']);
	}
	// new username
	if(isset($_POST['name'])){
		ServerInterface::getInstance()->updateUserName($_SESSION['serverid'], $_SESSION['userid'], $_POST['name']);
	}
	// new email
	if(isset($_POST['email'])){
		ServerInterface::getInstance()->updateUserEmail($_SESSION['serverid'], $_SESSION['userid'], $_POST['email']);
	}
	// remove texture
	if(isset($_GET['remove_texture'])){
		try{
			ServerInterface::getInstance()->updateUserTexture($_SESSION['serverid'], $_SESSION['userid'], array());
		}catch(Murmur_InvalidTextureException $exc){
			echo 'failed';
		}
	}
	// new texture
	if(isset($_FILES['texture'])){
		if(!file_exists($_FILES['texture']['tmp_name'])){
			echo '<div class="error">Temp file does not exist.</div>';
		}else{
			
			$fileExtension = pathinfo($_FILES['texture']['name']);
			$fileExtension = isset($fileExtension['extension']) ? $fileExtension['extension'] : '';
			
function stringToByteArray($str){
	return unpack('C*', $str);
}
function imgToString($imgRes){
	$tex = '';
	for($y=0; $y<imagesy($imgRes); $y++){
		for($x=0; $x<imagesx($imgRes); $x++){
			$colorIndex = imagecolorat($imgRes, $x, $y);
			$colors = imagecolorsforindex($imgRes, $colorIndex);
			// alpha has to be converted to be 0 and 254 (255 would be better) instead of 0 to 127 and inverted
			$tex = $tex.pack('c4', $colors['blue'], $colors['green'], $colors['red'], abs(254-$colors['alpha']*2));
		}
	}
	return $tex;
}
/*
 * used for memory intensive image calculations
 * Checks that memory_limit is high enough and increases it if necessary.
 */
function checkMemoryLimit(){
	// 40M should be enough, use 60M to be sure
	$tmp_memLim = ini_get('memoty_limit');
	if( intval(substr($tmp_memLim, 0, strlen($tmp_memLim)-1)) < 60 )
		ini_set('memory_limit', '60M');
}
			$tex = '';
			switch($fileExtension){
				case 'png':
					checkMemoryLimit();
					
					if(!$texImg = imagecreatefrompng($_FILES['texture']['tmp_name'])){
						echo '<div class="error">Error: Could not create image resource.</div>';
						break;
					}
					if( imagesx($texImg)!=600 || imagesy($texImg)!=60 ){
						echo '<div class="error">Error: Image size is not 600x60.</div>';
						break;
					}
					//TODO: check if we need those 2:
					imagealphablending($texImg, true);		// enablealpha blending
					imagesavealpha($texImg, true);			// save alphablending
					
					$tex = imgToString($texImg);
					imagedestroy($texImg);
					
					if( strlen($tex)!=144000 ){
						echo '<div class="error">Error: The conversation from image to data string failed.</div>';
						break;
					}
					
					$texArray = stringToByteArray($tex);
					
					if(ServerInterface::getInstance()->updateUserTexture($_SESSION['serverid'], $_SESSION['userid'], $texArray )){
						echo 'Texture has been uploaded and set<br/>';
					}else{
						echo '<div class="error">Failed to set image.</div>';
					}
					break;
				case 'jpg':
				case 'jpeg':
					checkMemoryLimit();
					
					if(!$texImg = imagecreatefromjpeg($_FILES['texture']['tmp_name'])){
						echo '<div class="error">Error: Could not create image resource.</div>';
						break;
					}
					if( imagesx($texImg)!=600 || imagesy($texImg)!=60 ){
						echo '<div class="error">Error: Image size is not 600x60.</div>';
						break;
					}
					
					$tex = imgToString($texImg);
					imagedestroy($texImg);
					
					if( strlen($tex)!=144000 ){
						echo '<div class="error">Error: The conversation from image to data string failed.</div>';
						break;
					}
					
					$texArray = unpack('C*', $tex);
					
					if(ServerInterface::getInstance()->updateUserTexture($_SESSION['serverid'], $_SESSION['userid'], $texArray )){
						echo 'Texture has been uploaded and set<br/>';
					}else{
						echo '<div class="error">Failed to set image.</div>';
					}
					
					break;
				case 'gif':
					checkMemoryLimit();
					
					if(!$texImg = imagecreatefromgif($_FILES['texture']['tmp_name'])){
						echo '<div class="error">Error: Could not create image resource.</div>';
						break;
					}
					if( imagesx($texImg)!=600 || imagesy($texImg)!=60 ){
						echo '<div class="error">Error: Image size is not 600x60.</div>';
						break;
					}
					
					$tex = imgToString($texImg);
					imagedestroy($texImg);
					
					if( strlen($tex)!=144000 ){
						echo '<div class="error">Error: The conversation from image to data string failed.</div>';
						break;
					}
					
					$texArray = unpack('C*', $tex);
					
					if(ServerInterface::getInstance()->updateUserTexture($_SESSION['serverid'], $_SESSION['userid'], $texArray )){
						echo 'Texture has been uploaded and set<br/>';
					}else{
						echo '<div class="error">Failed to set image.</div>';
					}
					break;
				
				// RAW RGBA Image Data
				case '':
				case 'raw':
					checkMemoryLimit();
					
					if($_FILES['texture']['size'] != 144000){
						echo '<div class="error">Your file could not be converted. Please check it.</div>';
						break;
					}
					
					if(!$fd = fopen($_FILES['texture']['tmp_name'], 'r')){
						echo '<div class="error">opening temp file failed</div>';
						break;
					}
					$tex = fread($fd, 144000);
					fclose($fd);
					
					// RGBA to BGRA
					// for each pixel, swap R with B (36000 = 600*60)
					for($i=0; $i<36000; $i++) {
						$red = $tex[$i*4];
						$tex[$i*4] = $tex[$i*4+2];
						$tex[$i*4+2] = $red;
					}
					
//					$tex = gzcompress($tex);
					
					$texArray = stringToByteArray($tex);
					
					if(ServerInterface::getInstance()->updateUserTexture($_SESSION['serverid'], $_SESSION['userid'], $texArray )){
						echo 'Texture has been uploaded and set<br/>';
					}else{
						echo '<div class="error">Failed to set image.</div>';
					}
					break;
				default:
					echo 'unknown file extension';
					break;
			}
			
			
			
			
		}
		
	}
}

?>
<div id="content">
	<h1><?php TranslationManager::echoText('profile_head'); ?></h1>
	<form action="?section=profile&amp;action=doedit" method="post" style="width:400px;"<?php if(isset($_GET['action'])&&$_GET['action']=='edit_texture') echo ' enctype="multipart/form-data"'; ?>>
		<table class="fullwidth">
			<tr><?php // SERVER Information (not changeable) ?>
				<td class="formitemname"><?php echo TranslationManager::getText('server'); ?>:</td>
				<td>
					<?php
						echo SettingsManager::getInstance()->getServerName($_SESSION['serverid']);
					?>
				</td>
				<td></td>
			</tr>
			<tr><?php // USERNAME ?>
				<td class="formitemname"><?php echo TranslationManager::getText('username'); ?>:</td>
				<td><?php
					if(isset($_GET['action']) && $_GET['action']=='edit_uname'){
						?><input type="text" name="name" value="<?php echo ServerInterface::getInstance()->getUsername($_SESSION['serverid'], $_SESSION['userid']); ?>" /><?php
					}else{
						echo ServerInterface::getInstance()->getUsername($_SESSION['serverid'], $_SESSION['userid']);
					} ?></td>
				<td class="alignl">
					<a href="?section=profile&amp;action=edit_uname" id="profile_uname_edit"<?php if(isset($_GET['action']) && $_GET['action']=='edit_uname'){ echo 'class="hidden"'; } ?>><?php TranslationManager::echoText('edit'); ?></a>
					<?php if(isset($_GET['action']) && $_GET['action']=='edit_uname'){ echo '<input type="submit" value="update"/>'; } ?><a href="?section=profile&amp;action=doedit_uname" id="profile_uname_update" class="hidden"><?php TranslationManager::echoText('update'); ?></a>
					<a href="?section=profile" id="profile_uname_cancel"<?php if(!isset($_GET['action']) || $_GET['action']!='edit_uname'){ ?> class="hidden"<?php } ?>><?php TranslationManager::echoText('cancel'); ?></a>
				</td>
			</tr>
			<tr><?php // PASSWORD ?>
				<td class="formitemname"><?php TranslationManager::echoText('password'); ?>:</td>
				<td><?php if(isset($_GET['action']) && $_GET['action']=='edit_pw'){ ?><input type="text" name="password" id="password" value="" /><?php }else{ echo '<span class="info" title="password is not displayed">*****</span>'; } ?></td>
				<td class="alignl">
					<a href="?section=profile&amp;action=edit_pw" id="profile_pw_edit"<?php if(isset($_GET['action']) && $_GET['action']=='edit_pw'){ ?> class="hidden"<?php } ?>><?php TranslationManager::echoText('edit'); ?></a>
					<?php if(isset($_GET['action']) && $_GET['action']=='edit_pw'){ echo '<input type="submit" value="update"/>'; } ?><a id="profile_pw_update" class="hidden"><?php TranslationManager::echoText('update'); ?></a>
					<a href="?section=profile" id="profile_pw_cancel"<?php if(!isset($_GET['action']) || $_GET['action']!='edit_pw'){ ?> class="hidden"<?php } ?>><?php TranslationManager::echoText('cancel'); ?></a></td>
			</tr>
			<tr><?php // E-MAIL ?>
				<td class="formitemname"><?php echo TranslationManager::getText('email'); ?>:</td>
				<td><?php
					if(isset($_GET['action']) && $_GET['action']=='edit_email'){
						?><input type="text" name="email" id="email" value="<?php echo ServerInterface::getInstance()->getUserEmail($_SESSION['serverid'], $_SESSION['userid']); ?>" /><?php
					}else{
						echo ServerInterface::getInstance()->getUserEmail($_SESSION['serverid'], $_SESSION['userid']);
					}
				?></td>
				<td class="alignl">
					<a href="?section=profile&amp;action=edit_email" id="profile_email_edit"<?php if(isset($_GET['action']) && $_GET['action']=='edit_email'){ ?> class="hidden"<?php } ?>><?php TranslationManager::echoText('edit'); ?></a>
					<?php if(isset($_GET['action']) && $_GET['action']=='edit_email'){ echo '<input type="submit" value="update"/>'; } ?><a id="profile_email_update" class="hidden"><?php TranslationManager::echoText('update'); ?></a>
					<a href="?section=profile" id="profile_email_cancel"<?php if(!isset($_GET['action']) || $_GET['action']!='edit_email'){ ?> class="hidden"<?php } ?>><?php TranslationManager::echoText('cancel'); ?></a></td>
			</tr>
			<tr><?php // Texture ?>
				<td class="formitemname"><?php echo TranslationManager::getText('texture'); ?>:</td>
				<td><?php
					if(isset($_GET['action']) && $_GET['action']=='edit_texture'){
						?><input type="file" name="texture" id="texture" value="<?php echo ServerInterface::getInstance()->getUserTexture($_SESSION['serverid'], $_SESSION['userid']); ?>" /><?php
					}else{
						$tex = ServerInterface::getInstance()->getUserTexture($_SESSION['serverid'], $_SESSION['userid']);
						if(count($tex)==0){
							TranslationManager::echoText('texture_none');
						}else{
							TranslationManager::echoText('texture_set');
						}
					}
				?></td>
				<td class="alignl">
					<a href="?section=profile&amp;action=edit_texture" id="profile_texture_edit"<?php if(isset($_GET['action']) && $_GET['action']=='edit_texture'){ ?> class="hidden"<?php } ?>><?php echo TranslationManager::getText('edit'); ?></a>
					<a href="?section=profile&amp;action=doedit&amp;remove_texture" id="profile_texture_remove"<?php if(isset($_GET['action']) && $_GET['action']=='edit_texture'){ ?> class="hidden"<?php } ?>><?php echo TranslationManager::getText('remove'); ?></a>
					<?php if(isset($_GET['action']) && $_GET['action']=='edit_texture'){ echo '<input type="submit" value="update"/>'; } ?><a id="profile_texture_update" class="hidden"><?php echo TranslationManager::getText('update'); ?></a>
					<a href="?section=profile" id="profile_texture_cancel"<?php if(!isset($_GET['action']) || $_GET['action']!='edit_texture'){ ?> class="hidden"<?php } ?>><?php echo TranslationManager::getText('cancel'); ?></a>
				</td>
			</tr>
		</table>
		
		<script type="text/javascript">
			$('#profile_uname_edit').click( function(event){
				$('#profile_uname_*').toggle( function(){$(this).removeClass('hidden');}, function(){$(this).addClass('hidden');} );
			} );
		</script>
	</form>
	<p <?php if(!isset($_GET['action']) || $_GET['action']!='edit_texture'){ ?> class="hidden"<?php } ?>><?php TranslationManager::getEcho('profile_note_texture'); ?>
</div>