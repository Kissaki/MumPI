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
	$txt['register_title'] = 'Registration Form';
	$txt['password_repeat'] = 'retype password';
	$txt['antispam'] = 'Anti-Spam';
	
	$txt['register_mail_auth_subj'] = 'Account Aktivierung';
	$txt['register_mail_auth_body'] = 'Du hast versucht einen Account auf der Seite %s (%s) auf dem Server %s zu erstellen.'."\n"
			.'Um deinen Account zu aktivieren öffne den folgenden Link in deinem Web-Browser:'."\n"
			.'%s?page=register&action=activate&key=%s'."\n"
			.'Danach solltest du dich sowohl im Interface, wie auch auf dem Mumble Server einloggen können.';
	
	$txt['doregister_try'] = 'Trying to register on selected server...';
	$txt['doregister_success'] = 'You successfully registered.';	
	$txt['register_success'] =  'You have successfully registered. You can now <a href="?page=login">log in</a> (also in mumble).';
	$txt['register_success_toActivate'] = 'You have successfully registered, however, your account is not activated yet.<br/>You will receive an email soon with an activation link you have to click.';
	$txt['register_fail_noserver'] = 'no server specified!<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
	$txt['register_fail_noNameFound'] = 'no name specified!<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
	$txt['register_fail_noPasswordFound'] = 'no password specified!<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
	$txt['register_fail_passwordMatch'] = 'Your passwords did not match!<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
	$txt['register_fail_noEmail'] = 'You did not enter an email address, however, this is required.<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
	$txt['register_fail_emailinvalid'] = 'You did not enter a correct email address.<br/><a onclick="history.go(-1); return false;" href="?page=register">go back</a>';
	$txt['register_fail_wrongCaptcha'] = '<div class="error">Captcha Incorrect.</div>';
	$txt['register_activate_success'] = 'Your account should now be activated. Try to log in.';
	
	$txt['register_help_server'] = 'Select the server you want to register on.';
	$txt['register_help_username'] = 'Specify the username you want to use and log in with.<br/>Note that depending on the server settings, some characters or especially special symbols may not be allowed.';
	$txt['register_help_email'] = 'Enter your email address.<br/>Depending on the server setting you may or may not have to enter it and may or may not receive an authentification mail to activate/create your account.';
	$txt['register_help_password'] = 'Come up with a password.<br/>Be adised: A secure password should consist of mixed/random numbers and letters, or better even special characters.<br/>Normal words or common numbers can be guessed or brute-forced.<br/>A number of or more than 8 Symbols should be good.';
	$txt['register_help_password2'] = 'Retype your password, so we can be sure you did not mistype it.';
	$txt['register_help_captcha'] = 'This field is to prevent spam.<br/>Calculate and enter the result of the calculation given on the image.';

?>