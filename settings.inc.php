<?php
	// Don't add trailing slashes
	$muDir = 'E:/xxx/Mumble PHP Interface/Mumble PHP Interface';
	$theme = 'default';
	$lang = 'en';
	
	$site['url'] = 'http://localhost/Mumble%20PHP%20Interface';
	
	
	
	$site['title'] = 'New Mumble Interface';
	$site['description'] = 'New Mumble Interface';
	$site['keywords'] = 'mumble,murmur,web-interface,registration,account,management,voip';
	
	
	// Debug? - This should be turned off (commented out) for production sites. 
	error_reporting(E_ALL);
	
	
	// Don't edit the following. Settings to set up end here.
	$themepath = '/themes/'.$theme;
	$themedir = $muDir.$themepath;
	$themeurl = $site['url'].$themepath;
?>