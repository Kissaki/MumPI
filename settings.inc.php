<?php die(); ?>
// Syntax: settingname = value
// // for comments
// whitespaces before and after key or value (line or =) will be trimmed
// 1 for true, 0 for false

localDir=E:\xxx\Mumble PHP Interface\Mumble PHP Interface
url=http://localhost/Mumble%20PHP%20Interface
theme=default
language=en

// interface may be: ice, (dbus may be added at a later time)
dbInterface	= ice

// db type for Interface functionality
// may be: filesystem, (TODO: add mysql, psql, sqlite)
dbType		= filesystem
// not necessary for filesystem, but for mysql, psql etc:
db_username	=
db_password	=
db_database	=
db_tableprefix	=

site_title = New Mumble Interface
site_description=New Mumble Interface
site_keywords=mumble,murmur,web-interface,registration,account,management,voip

// For Each Server set:
//   server_<nextnr>_serverid = 
//   server_<nextnr>_name = 
//   server_<nextnr>_forcemail = 
//   server_<nextnr>_authbymail = 
// forceemail: force to enter a mail address. This is always true if authbymail is true.
// authbymail: "normal" account activation by link sent by mail
// Begin with 1 as <nextnr> increasing it by 1 for each server.
server_numberOfServers		= 2

server_1_serverid			= 1
server_1_name				= my custom server
server_1_allowlogin			= 1
server_1_allowregistration	= 1
server_1_forcemail			= 1
server_1_authbymail			= 1

server_2_serverid			= 4
server_2_name				= my private server
server_2_allowlogin			= 1
server_2_allowregistration	= 0
server_2_forcemail			= 1
server_2_authbymail			= 1

// Debug? - This should be turned off (commented out) for production sites.
debug = 1
