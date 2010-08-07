<?php
//TODO: implement javascript version of form

if (isset($_GET['action']) && $_GET['action']=='doedit') {

	// login check
	if (!isset($_SESSION['userid'])) {
		die();
	}

	// new password
	if (isset($_POST['password'])) {
		if (empty($_POST['password'])) {
			MessageManager::addWarning(tr('profile_emptypassword'));
		} else {
			ServerInterface::getInstance()->updateUserPw($_SESSION['serverid'], $_SESSION['userid'], $_POST['password']);
		}
	}

	// new username
	if (isset($_POST['name'])) {
		ServerInterface::getInstance()->updateUserName($_SESSION['serverid'], $_SESSION['userid'], $_POST['name']);
	}

	// new email
	if (isset($_POST['email'])) {
		ServerInterface::getInstance()->updateUserEmail($_SESSION['serverid'], $_SESSION['userid'], $_POST['email']);
	}

	// remove texture
	if (isset($_GET['remove_texture'])) {
		try {
			ServerInterface::getInstance()->updateUserTexture($_SESSION['serverid'], $_SESSION['userid'], array());
		} catch(Murmur_InvalidTextureException $exc) {
			MessageManager::addWarning(tr('profile_removetexturefailed'));
		}
	}

	// new texture
	//TODO reimplement setting texture
	if (isset($_FILES['texture'])) {
		if (!file_exists($_FILES['texture']['tmp_name'])) {
			MessageManager::addWarning(tr('profile_texture_notempfile'));
		} else {
			$imgData = file_get_contents($_FILES['texture']['tmp_name']);
			ServerInterface::getInstance()->updateUserTexture($_SESSION['serverid'], $_SESSION['userid'], $imgData);
		}
	}
}

?>
<div id="content">
	<h1><?php echo TranslationManager::getText('profile_head'); ?></h1>
	<form action="?page=profile&amp;action=doedit" method="post" style="width:420px;"<?php if(isset($_GET['action']) && $_GET['action']=='edit_texture') echo ' enctype="multipart/form-data"'; ?>>
		<table class="fullwidth">
			<tr><?php // SERVER Information (not changeable) ?>
				<td class="formitemname"><?php echo tr('server'); ?>:</td>
				<td>
					<?php
						echo SettingsManager::getInstance()->getServerName($_SESSION['serverid']);
					?>
				</td>
				<td></td>
			</tr>
			<tr><?php // USERNAME ?>
				<td class="formitemname"><?php echo tr('username'); ?>:</td>
				<td>
					<?php
						if (isset($_GET['action']) && $_GET['action']=='edit_uname') {
							?>
								<input type="text" name="name" value="<?php echo ServerInterface::getInstance()->getUsername($_SESSION['serverid'], $_SESSION['userid']); ?>" />
							<?php
						} else {
							echo ServerInterface::getInstance()->getUsername($_SESSION['serverid'], $_SESSION['userid']);
						}
					?>
				</td>
				<td class="alignl">
					<a href="?page=profile&amp;action=edit_uname" id="profile_uname_edit"<?php if(isset($_GET['action']) && $_GET['action']=='edit_uname'){ echo 'class="hidden"'; } ?>>
						<?php echo tr('edit'); ?>
					</a>
					<?php
						if (isset($_GET['action']) && $_GET['action']=='edit_uname') {
							echo '<input type="submit" value="update"/>';
						}
					?>
					<a href="?page=profile&amp;action=doedit_uname" id="profile_uname_update" class="hidden">
						<?php echo tr('update'); ?>
					</a>
					<a href="?page=profile" id="profile_uname_cancel"<?php if(!isset($_GET['action']) || $_GET['action']!='edit_uname'){ ?> class="hidden"<?php } ?>>
						<?php echo tr('cancel'); ?>
					</a>
				</td>
			</tr>
			<tr><?php // PASSWORD ?>
				<td class="formitemname"><?php echo tr('password'); ?>:</td>
				<td>
					<?php
						if (isset($_GET['action']) && $_GET['action']=='edit_pw') {
							?>
								<input type="text" name="password" id="password" value="" />
							<?php
						} else {
							?>
								<span class="info" title="password is not displayed">*****</span>
							<?php
						}
					?>
				</td>
				<td class="alignl">
					<a href="?page=profile&amp;action=edit_pw" id="profile_pw_edit"<?php if(isset($_GET['action']) && $_GET['action']=='edit_pw'){ ?> class="hidden"<?php } ?>>
						<?php echo tr('edit'); ?>
					</a>
					<?php
						if (isset($_GET['action']) && $_GET['action']=='edit_pw') {
							?>
								<input type="submit" value="update"/>
							<?php
						}
					?>
					<a id="profile_pw_update" class="hidden">
						<?php echo tr('update'); ?>
					</a>
					<a href="?page=profile" id="profile_pw_cancel"<?php if(!isset($_GET['action']) || $_GET['action']!='edit_pw'){ ?> class="hidden"<?php } ?>>
						<?php echo tr('cancel'); ?>
					</a>
				</td>
			</tr>
			<tr><?php // E-MAIL ?>
				<td class="formitemname">
					<?php echo tr('email'); ?>:
				</td>
				<td>
					<?php
						if (isset($_GET['action']) && $_GET['action']=='edit_email') {
							?>
								<input type="text" name="email" id="email" value="<?php echo ServerInterface::getInstance()->getUserEmail($_SESSION['serverid'], $_SESSION['userid']); ?>" />
							<?php
						} else {
							echo ServerInterface::getInstance()->getUserEmail($_SESSION['serverid'], $_SESSION['userid']);
						}
					?>
				</td>
				<td class="alignl">
					<a href="?page=profile&amp;action=edit_email" id="profile_email_edit"<?php if(isset($_GET['action']) && $_GET['action']=='edit_email'){ ?> class="hidden"<?php } ?>>
						<?php echo tr('edit'); ?>
					</a>
					<?php
						if (isset($_GET['action']) && $_GET['action']=='edit_email') {
							?>
								<input type="submit" value="update"/>
							<?php
						}
					?>
					<a id="profile_email_update" class="hidden">
						<?php echo tr('update'); ?>
					</a>
					<a href="?page=profile" id="profile_email_cancel"<?php if(!isset($_GET['action']) || $_GET['action']!='edit_email'){ ?> class="hidden"<?php } ?>>
						<?php echo tr('cancel'); ?>
					</a>
				</td>
			</tr>
			<tr>
				<?php
					// Texture
					$userAvatarByteSequence = ServerInterface::getInstance()->getUserTexture($_SESSION['serverid'], $_SESSION['userid']);
					$isTextureSet = (count($userAvatarByteSequence) > 0);
				?>
				<td class="formitemname">
					<?php echo tr('texture'); ?>:
				</td>
				<td>
					<?php
						if ($isTextureSet) {
							echo tr('texture_set');
							$texBytes = '';
							foreach ($userAvatarByteSequence as $val) {
								$texBytes .= chr($val);
							}
							$texB64 = base64_encode($texBytes);
							?>
								<div id="userAva">
									<div id="userAvaToggle" style="font-style:italic;">
										show
									</div>
									<div id="userAvaImage" style="display:none;">
										<img src="data:image/*;base64,<?php echo $texB64; ?>" alt="" />
									</div>
								</div>
								<script type="text/javascript">
									/*<![CDATA[*/
										jQuery('#userAvaToggle').toggle(
												function (eventObj) {
												  jQuery('#userAvaImage').css('display', 'block');
												},
												function (eventObj) {
												  jQuery('#userAvaImage').css('display', 'none');
												}
											);
									/*]]>*/
								</script>
							<?php
						} else {
							echo tr('texture_none');
						}
					?>
				</td>
				<td class="alignl">
					<?php
						if ($isTextureSet) {
							echo '<a href="?page=profile&amp;action=doedit&amp;remove_texture" id="profile_texture_remove" onclick="return confirm(\'Are you sure you want to remove your user-avatar?\');"';
							if (isset($_GET['action']) && ($_GET['action'] == 'edit_texture')) {
								echo ' class="hidden"';
							}
							echo '>';
							echo tr('remove');
							echo '</a>';
						}
					?>
				</td>
			</tr>
		</table>

		<script type="text/javascript">
			/*<![CDATA[*/
					$('#profile_uname_edit').click(
						function(event) {
							$('#profile_uname_*').toggle(
									function(){
										$(this).removeClass('hidden');
									},
									function() {
										$(this).addClass('hidden');}
								);
							}
						);
				/*]]>*/
		</script>
	</form>
	<p <?php if(!isset($_GET['action']) || $_GET['action']!='edit_texture'){ ?> class="hidden"<?php } ?>>
		<?php echo tr('profile_note_texture'); ?>
	</p>
</div>