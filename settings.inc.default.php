<?php
// Syntax: settingname = value
// // for comments
// whitespaces before and after key or value (line or =) will be ignored
// 1 for true, 0 for false

// Debug? - This should be turned off for production sites.
// It is meant to find issues in MumPI, like/or lost error messages etc.
$debug = false;

// allow freely calling data for a web serverviewer? http://mumble.sourceforge.net/Channel_Viewer_Protocol
// it can be called via URL pointed to the main dir (where this settings file is located) + ?view=json&serverId=1
$allowChannelViewerWebservice = true;
// use SVG images in viewer
$viewerUseSVGImages = false;
// This is recommended to be true to prevent spam/abuse by bots etc. This requires the php gd extension (image manipulation). The captcha is used for user-registration.
$useCaptcha      = true;
// Show a link to the admin section in the user section?
$showAdminLink   = true;
// currently available: en, de ; en is recommended
$defaultLanguage = 'en';
// only "default" right now
$theme           = 'default';

// Interface to use. Currently available: ice
$dbInterface_type       = 'ice';
// Ice target address.
// If you are using IcePHP 3.5 with Mumble 1.2.4 or lower (which uses Ice 3.4), use the -e parameter for compatibility.
// For example: 'Meta -e 1.0:tcp -h 127.0.0.1 -p 6502'
// Default: 'Meta:tcp -h 127.0.0.1 -p 6502'
$dbInterface_address    = 'Meta:tcp -h 127.0.0.1 -p 6502';
// if you set an icesecret password in your murmur.ini file, specify it here
$dbInterface_icesecrets = array(
		// for Murmur 1.2.2: if you set "icesecret" in your Murmur.ini, set "secret" here to your icesecret value.
		// for Murmur > 1.2.2: you can only set "secret" here, thus you can only use either "icesecretread" or "icesecretwrite" you set in your Murmur.ini.
		//   This means if you want write access (to be able to fully use the admin interface) you can only use one value for both Murmur-secrets (this was tested on snapshot 02071e).
		'secret' => '',
);
// This setting only becomes active for php-zeroc-ice versions at or above 3.4. Before 3.4 IcePHPs ice.slice setting was used.
// PHP file generated from murmur.ice file with slice2php (see FAQ). Has to be in MumPIs classes subdir.
// This should specify a file that exists and matches your murmur server version as close as possible.
// May be values like Murmur_1.2.3.php or Murmur_1.2.4.php (check your MumPI/classes folder).
// If you have a different version of Mumble-Server / Murmur, you may want to compile it yourself; see FAQ on how to: https://github.com/Kissaki/MumPI/wiki/FAQ
$iceGeneratedMurmurPHPFileName = 'Murmur_1.2.4.php';

// db type for Interface functionality
// (does not have anything to do with mumble/murmur)
// specify one of the following: filesystem
$dbType           = 'filesystem';

$site_title       = 'Mumble Interface';
$site_description = 'Mumble Interface to register on a mumble server and edit your account as well as upload a user-texture for the overlay.';
$site_keywords    = 'mumble,murmur,web-interface,registration,account,management,voip,kcode';

// if you want the viewer to link the channels (click to connect) specify the servers address here (e.g. IP, or a domain)
// key: serverId, value: address (without port)
$viewer_serverAddresses = array(
		//example:
		//1 => 'kcode.de',
		//3 => '192.168.0.1',
);

// For the interface to be able to send emails, make sure your php is set up
//   to be able to send mails correctly. If it does not work or you want to use
//   different settings from the default ones for this interface,
//   set the corresponding following values (uncomment them):
// Windows:
//ini_set('SMTP', '');				// e.g. localhost or smtp.sample.com	// Windows only setting
//ini_set('smtp_port', '');			// 										// Windows only
//ini_set('sendmail_from', '');		// e.g. admin@yourdomain.com			// Windows only
// Linux/Unix:
//ini_set('sendmail_path', '');		// Path to sendmail program, see http://php.net/manual/en/mail.configuration.php#ini.sendmail-path

// The server configuration can also be done from the Admin Section of the interface.
//   No need to do it here.
// If you disallow login and registration, the server will only be viewable in the admin section of the interface.
//   Allowing one of them will display it on the corresponding page.
// For Each Server set:
//$servers[<serverid>]['name']              = '<server name in the interface>';
//$servers[<serverid>]['allowlogin']        = true;
//$servers[<serverid>]['allowregistration'] = true;
//$servers[<serverid>]['forcemail']         = false;
//$servers[<serverid>]['authbymail']        = false;
// <serverid> is the virtual servers ID, the default server ID (first server of process) is 1
// forceemail: force to enter a mail address. This is always true if authbymail is true.
// authbymail: account has to be activated with a code sent to the mail address
$servers = array();

$servers[1]['name']       = 'my server';
$servers[1]['allowlogin'] = true;
$servers[1]['allowregistration'] = true;
$servers[1]['forcemail']  = true;
$servers[1]['authbymail'] = false;

$servers[2]['name']       = 'my private server';
$servers[2]['allowlogin'] = true;
$servers[2]['allowregistration'] = false;
$servers[2]['forcemail']  = true;
$servers[2]['authbymail'] = true;

