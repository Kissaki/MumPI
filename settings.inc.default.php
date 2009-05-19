<?php
// Syntax: settingname = value
// // for comments
// whitespaces before and after key or value (line or =) will be ignored
// 1 for true, 0 for false

// Debug? - This should be turned off for production sites.
$debug = false;

$theme	= 'default';
$defaultLanguage = 'en';	// currently available: en, de
$useCaptcha = true;		// This is recommended to be true to prevent spam/abuse by bots etc. This requires the php gd extension (image manipulation).

// Interface to use. Currently available: ice
$dbInterface_type		= 'ice';
$dbInterface_address	= 'Meta:tcp -h 127.0.0.1 -p 6502';

// db type for Interface functionality
// (does not have anything to do with mumble/murmur)
// specify one of the following: filesystem
// later, the following will be implemented: (TODO: add mysql, psql, sqlite)
$dbType		= 'filesystem';

// not necessary for dbType filesystem, but for mysql, psql etc (so not at all yet):
$db_username    = '';
$db_password    = '';
$db_database    = '';
$db_tableprefix = '';

$site_title = 'Mumble Interface';
$site_description='Mumble Interface to register on a mumble server and edit your account as well as upload a user-texture for the overlay.';
$site_keywords='mumble,murmur,web-interface,registration,account,management,voip,kcode';

// For Each Server set:
//$servers[<serverid>]['name']              = '<server name in the interface>';
//$servers[<serverid>]['allowlogin']        = true;
//$servers[<serverid>]['allowregistration'] = true;
//$servers[<serverid>]['forcemail']         = false;
//$servers[<serverid>]['authbymail']        = false;
// forceemail: force to enter a mail address. This is always true if authbymail is true.
// authbymail: account has to be activated with a code sent to the mail address
// The default virtual server has the id 1
// Neither allowing login nor registration will hide it from the interface. You can then only see it from the admin section.
$servers = array();

$servers[1]['name'] = 'my server';
$servers[1]['allowlogin'] = true;
$servers[1]['allowregistration'] = true;
$servers[1]['forcemail'] = true;
$servers[1]['authbymail'] = false;

$servers[2]['name'] = 'my private server';
$servers[2]['allowlogin'] = true;
$servers[2]['allowregistration'] = false;
$servers[2]['forcemail'] = true;
$servers[2]['authbymail'] = true;

?>