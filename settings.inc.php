<?php
	// Don't add trailing slashes
	$muPI_muDir = 'E:/xxx/Mumble PHP Interface/Mumble PHP Interface';
	$muPI_theme = 'default';
	$muPI_lang = 'en';
	
	$muPI_site['url'] = 'http://localhost/Mumble%20PHP%20Interface';
	$muPI_site['title'] = 'New Mumble Interface';
	$muPI_site['description'] = 'New Mumble Interface';
	$muPI_site['keywords'] = 'mumble,murmur,web-interface,registration,account,management,voip';
	
	$muPI_dbInterface = 'ice';	// this may be: ice
	
	$muPI_sett_server['numberOfServers'] = 1;
	// For Each Server with serverid <srvid> set:
	// $sett_server[<srvid>]['name'] = 
	// $sett_server[<srvid>]['forcemail'] =
	// $sett_server[<srvid>]['authbymail'] =
	$muPI_sett_server[1]['name'] = 'my custom server';
	$muPI_sett_server[1]['forcemail'] = true;	// force to enter a mail address
	$muPI_sett_server[1]['authbymail'] = true;	// "normal" account activation by link sent by mail
	$muPI_sett_server[2]['name'] = 'my private server';
	$muPI_sett_server[2]['forcemail'] = true;	// force to enter a mail address
	$muPI_sett_server[2]['authbymail'] = true;	// "normal" account activation by link sent by mail
	// Debug? - This should be turned off (commented out) for production sites. 
	error_reporting(E_ALL);
	
	
	// Don't edit the following. Settings to set up end here.
	$muPI_themepath = '/themes/'.$muPI_theme;
	$muPI_themedir = $muPI_muDir.$muPI_themepath;
	$muPI_themeurl = $muPI_site['url'].$muPI_themepath;
?>