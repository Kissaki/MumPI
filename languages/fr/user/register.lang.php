<?php
/**
 * @subpackage 	languages (mumble PHP Interface v0.3.6.7)
 * @author 		esion - esion99@gmail.com
 * @since 		25 oct. 2009
 * @version		1.0 - 25 oct. 2009 - esion
 */
/**
 * Language file for section: user, page: register
 */

	// Register
	$txt['register_title']	= 'Formulaire d\'enregistrement';
	$txt['password_repeat']	= 'entrez votre mot de passe à nouveau';
	$txt['antispam']		= 'Anti-Spam';

	$txt['register_mail_auth_subj'] = 'Activation de votre compte';
	$txt['register_mail_auth_body'] = 'Vous avez enregistré un compte sur %s (%s) sur le serveur %s.'."\n"
			.'Pour activer votre compte ouvrez le lien suivant dans un navigateur :'."\n"
			.'%s?page=register&action=activate&key=%s'."\n"
			.'Vous pourrez ensuite vous connecter sur le serveur mumble ainsi que sur l\'interface web.';

	$txt['doregister_try']				= 'Enregistrement sur le serveur selectionné...';
	$txt['doregister_success']			= 'Vous vous êtes enregistré avc succès.';
	$txt['register_success']			= 'Vous vous êtes enregistré avc succès. Vous pouvez maintenant vous <a href="?page=login">connecter</a> (ainsi que sur mumble).';
	$txt['register_success_toActivate']	= 'Vous vous êtes enregistré avc succès, néanmoins votre compte n\'est pas encore actif.<br/>Vous allez recevoir un email avec un lien vous permettant d\activer votre compte.';
	$txt['register_fail_noserver']		= 'aucun serveur spécifié!<br/><a onclick="history.go(-1); return false;" href="?page=register">Retour</a>';
	$txt['register_fail_noNameFound']	= 'aucun nom spécifié!<br/><a onclick="history.go(-1); return false;" href="?page=register">Retour</a>';
	$txt['register_fail_noPasswordFound']	= 'aucun mot de passe spécifié!<br/><a onclick="history.go(-1); return false;" href="?page=register">Retour</a>';
	$txt['register_fail_passwordMatch']	= 'Vos mots de passe ne sont pas identiques!<br/><a onclick="history.go(-1); return false;" href="?page=register">Retour</a>';
	$txt['register_fail_noEmail']		= 'Vous n\'avez pas entré d\'adresse email, celle-ci est requise.<br/><a onclick="history.go(-1); return false;" href="?page=register">Retour</a>';
	$txt['register_fail_emailinvalid']	= 'L\'adresse email que vous avez entré est invalide.<br/><a onclick="history.go(-1); return false;" href="?page=register">Retour</a>';
	$txt['register_fail_wrongCaptcha']	= '<div class="error">Captcha invalide.</div>';
	$txt['register_activate_success']	= 'Votre compte a été activé. Essayez de vous connecter.';

	$txt['register_help_server']		= 'Selectionnez le serveur sur lequel vous voulez vous enregistrer.';
	$txt['register_help_username']		= 'Specifiez le nom d\'utilisateur que vous voulez utiliser.<br/>Notez que certains caractères, plus particulièrement les caractères spéciaux ne sont pas autorisés selon les paramètres du serveur.';
	$txt['register_help_email']			= 'Entrez votre adresse email.<br/>Selon les paramètres du serveur celle-ci n\'est pas obligatoire et vous ne recevrez peut être pas l\'email d\'activation.';
	$txt['register_help_password']		= 'Trouvez un mot de passe.<br/>Soyez informé: Un mot de passe sécurisé consiste en un mélange aléatoire de chiffres et de lettres ou mieux avec des caractères spéciaux.<br/>Le mots ou les nombres courant peuvent être devinés ou brute-forcés.<br/>Un minimum de 8 symbols devrait être bon.';
	$txt['register_help_password2']		= 'Entrez à nouveau votre mot de passe.';
	$txt['register_help_captcha']		= 'Ce champ est utile pour éviter le spam.<br/>Calculez et entrez le résultat indiqué par l\'image.';
