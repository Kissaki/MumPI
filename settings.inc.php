<?php
	// Don't add trailing slashes
	$muPI_muDir = dirname(__FILE__);
	$muPI_url = 'http://localhost/Mumble%20PHP%20Interface';
	
	$muPI_theme = 'default';
	$muPI_lang = 'en';
	$muPI_dbInterface = 'ice';	// this may be: ice
	
	$muPI_site['title'] = 'New Mumble Interface';
	$muPI_site['description'] = 'New Mumble Interface';
	$muPI_site['keywords'] = 'mumble,murmur,web-interface,registration,account,management,voip';
	
	
	$muPI_sett_server['numberOfServers'] = 1;
	// For Each Server set:
	//   $sett_server[<nextnr>]['serverid'] = 
	//   $sett_server[<nextnr>]['name'] = 
	//   $sett_server[<nextnr>]['forcemail'] = 
	//   $sett_server[<nextnr>]['authbymail'] = 
	// Begin with <nextnr> := 1 increasing it by 1 for each server.
	$muPI_sett_server[1]['serverid'] = 1;
	$muPI_sett_server[1]['name'] = 'my custom server';
	$muPI_sett_server[1]['forcemail'] = true;	// force to enter a mail address. This is always true if authbymail is true.
	$muPI_sett_server[1]['authbymail'] = true;	// "normal" account activation by link sent by mail
	$muPI_sett_server[2]['serverid'] = 4;
	$muPI_sett_server[2]['name'] = 'my private server';
	$muPI_sett_server[2]['forcemail'] = true;	// force to enter a mail address
	$muPI_sett_server[2]['authbymail'] = true;	// "normal" account activation by link sent by mail
	
	// Debug? - This should be turned off (commented out) for production sites. 
//	error_reporting(E_ALL);
	
	
	// Don't edit the following. Settings to set up end here.
	$muPI_themepath = '/themes/'.$muPI_theme;
	$muPI_themedir = $muPI_muDir.$muPI_themepath;
	$muPI_themeurl = $muPI_url.$muPI_themepath;
?>