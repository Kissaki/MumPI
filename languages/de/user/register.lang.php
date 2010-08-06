<?php
/**
 * Language file for section: user, page: register
 */

	// Register
	$txt['register_title'] = 'Registrierungs Formular';
	$txt['password_repeat'] = 'Passwort (erneut)';
	$txt['antispam'] = 'Anti-Spam';

	$txt['register_mail_auth_subj'] = 'Account Aktivierung';
	$txt['register_mail_auth_body'] = 'Du hast versucht einen Account auf der Seite %s (%s) auf dem Server %s zu erstellen.'."\n"
			.'Um deinen Account zu aktivieren öffne den folgenden Link in deinem Web-Browser:'."\n"
			.'%s?page=register&action=activate&key=%s'."\n"
			.'Danach solltest du dich sowohl im Interface, wie auch auf dem Mumble Server einloggen können.';

	$txt['doregister_try']		= 'Registriere auf dem Server...';
	$txt['doregister_success']	= 'Du hast dich erfolgreich registriert.';
	$txt['register_success']	=  'Du hast dich erfolgreich registriert. Du kannst dich nun <a href="?page=login">einloggen</a> (auch in Mumble).';
	$txt['register_success_toActivate'] = 'Du hast dich erfolgreich registriert, aber dein Benutzeraccount ist noch nicht aktiviert.<br/>Du wirst bald eine E-Mail erhalten, mit einem Aktivierungs-Link den du klicken musst.';
	$txt['register_fail_noserver']		= 'Kein Server gewählt!<br/><a onclick="history.go(-1); return false;" href="?page=register">Zurück</a>';
	$txt['register_fail_noNameFound']	= 'Kein Name angegeben!<br/><a onclick="history.go(-1); return false;" href="?page=register">Zurück</a>';
	$txt['register_fail_noPasswordFound'] = 'Kein Passwort angegeben!<br/><a onclick="history.go(-1); return false;" href="?page=register">Zurück</a>';
	$txt['register_fail_passwordMatch']	= 'Deine Passwörter haben nicht überein gestimmt!<br/><a onclick="history.go(-1); return false;" href="?page=register">Zurück</a>';
	$txt['register_fail_noEmail']		= 'Du hast keine E-Mail Adresse eingegeben, was aber notwendig ist.<br/><a onclick="history.go(-1); return false;" href="?page=register">Zurück</a>';
	$txt['register_fail_emailinvalid']	= 'Du hast eine nicht korrekte E-Mail Adresse eingegeben.<br/><a onclick="history.go(-1); return false;" href="?page=register">Zurück</a>';
	$txt['register_fail_wrongCaptcha']	= '<div class="error">Captcha falsch.</div>';
	$txt['register_activate_success']	= 'Dein Benutzeraccount sollte jetzt aktiviert sein. Versuch dich einzuloggen.';

	$txt['register_help_server']		= 'Wähle den Server, auf welchem du dich registrieren möchtest.';
	$txt['register_help_username']		= 'Gib den Benutzernamen ein, welchen du in Zukunft verwenden möchtest.<br/>Beachte, dass je nach Servereinstellung bestimmte Zeichen, vor allem Sonderzeichen, verboten sein können.';
	$txt['register_help_email']			= 'Gib deine E-Mail Adresse ein.<br/>Je nach Server Einstellung musst du sie vielleicht gar nicht eingeben oder über eine Aktivierungs-Mail deinen Account erst aktivieren.';
	$txt['register_help_password']		= 'Denk dir ein Passwort aus.<br/>Empfehlung: Ein sicheres Passwort sollte aus einer zufälligen, durcheinandergewürfelten Reihenfolge von Zahlen und Buchstaben bestehen, besser noch ein paar Sonderzeichen.<br/>Normale Wörter oder übliche Zahlenkombinationen können leicht erraten oder berechnet/über brute-force herausgefunden werden.<br/>Eine Anzahl von 8 oder mehr Zeichen sollten es schon sein.';
	$txt['register_help_password2']		= 'Gib dein Passwort erneut ein, damit wir sicher sind, dass du dich nicht vertippt hast.';
	$txt['register_help_captcha']		= 'Dieses Feld ist vorhanden, um Spam zu verhindern.<br/>Berechne das Ergebnis der Rechnung im Bild und gib es ein.';
