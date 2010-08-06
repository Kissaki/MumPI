<?php
/**
 * Language file for section: user, page: register
 */

	// Register
	$txt['register_title']	= 'Registration Form';
	$txt['password_repeat']	= 'retype password';
	$txt['antispam']		= 'Anti-Spam';

	$txt['register_mail_auth_subj'] = 'Account Activation';
	$txt['register_mail_auth_body'] = 'You tried to register an account on %s (%s) on the server %s.'."\n"
			.'To activate your account open the following link in your webbrowser:'."\n"
			.'%s?page=register&action=activate&key=%s'."\n"
			.'Then you should be able to log in on the interface and on the mumble server.';

	$txt['doregister_try']				= 'Trying to register on selected server...';
	$txt['doregister_success']			= 'You successfully registered.';
	$txt['register_success']			=  'You have successfully registered. You can now <a href="?page=login">log in</a> (also in mumble).';
	$txt['register_success_toActivate']	= 'You have successfully registered, however, your account is not activated yet.<br/>You will receive an email soon with an activation link you have to click.';
	$txt['register_fail_noserver']		= 'no server specified!<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
	$txt['register_fail_noNameFound']	= 'no name specified!<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
	$txt['register_fail_noPasswordFound']	= 'no password specified!<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
	$txt['register_fail_passwordMatch']	= 'Your passwords did not match!<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
	$txt['register_fail_noEmail']		= 'You did not enter an email address, however, this is required.<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
	$txt['register_fail_emailinvalid']	= 'You did not enter a correct email address.<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
	$txt['register_fail_wrongCaptcha']	= '<div class="error">Captcha Incorrect.</div>';
	$txt['register_activate_success']	= 'Your account should now be activated. Try to log in.';

	$txt['register_help_server']		= 'Select the server you want to register on.';
	$txt['register_help_username']		= 'Specify the username you want to use and log in with.<br/>Note that depending on the server settings, some characters or especially special symbols may not be allowed.';
	$txt['register_help_email']			= 'Enter your email address.<br/>Depending on the server setting you may or may not have to enter it and may or may not receive an authentification mail to activate/create your account.';
	$txt['register_help_password']		= 'Come up with a password.<br/>Be adised: A secure password should consist of mixed/random numbers and letters, or better even special characters.<br/>Normal words or common numbers can be guessed or brute-forced.<br/>A number of or more than 8 Symbols should be good.';
	$txt['register_help_password2']		= 'Retype your password, so we can be sure you did not mistype it.';
	$txt['register_help_captcha']		= 'This field is to prevent spam.<br/>Calculate and enter the result of the calculation given on the image.';
