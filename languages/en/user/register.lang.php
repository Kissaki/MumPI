<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */
/**
 * Language file for section: user, page: register
 */

	// Register
	$txt['password_repeat'] = 'retype password';
	$txt['antispam'] = 'Anti-Spam';
	
	$txt['doregister_try'] = 'Trying to register on selected server...';
	$txt['doregister_success'] = 'You successfully registered.';	
	$txt['register_success'] =  'You have successfully registered. You can now <a href="?page=login">log in</a> (also in mumble).';
	$txt['register_success_toActivate'] = 'You have successfully registered, however, your account is not activated yet.<br/>You will receive an email soon with an activation link you have to click.';
	$txt['register_fail_noserver'] = 'no server specified!<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
	$txt['register_fail_noNameFound'] = 'no name specified!<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
	$txt['register_fail_noPasswordFound'] = 'no password specified!<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
	$txt['register_fail_passwordMatch'] = 'Your passwords did not match!<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
	$txt['register_fail_noEmail'] = 'You did not enter an email address, however, this is required.<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
	$txt['register_fail_wrongCaptcha'] = '<div class="error">Captcha Incorrect.</div>';
	$txt['register_activate_success'] = 'Your account should now be activated. Try to log in.';
	
	$txt['register_help_captcha'] = 'This field is to prevent spam.\\nCalculate the result and enter it into the text box.';

?>