<?php
/**
 * This is the language file with text strings that will be used in the admin section
 */

	// Main Menu
	$txt['home'] = 'Home';
	$txt['meta'] = 'Meta';
	$txt['server'] = 'Server';
	$txt['admins'] = 'Admins';
	$txt['logout'] = 'Log Out';

	$txt['error_AdminAccountAlreadyExists'] = 'Could not add the admin account because one with that loginname already exists. Please try again with a different login.';
	$txt['db_admingroup_namealreadyexists'] = 'An admin group with that name already exists.';
	$txt['db_error_admingroupassoc_alreadyexists'] = 'That admin already seems to be in that group.';

	$txt['info_ip_bits'] = 'Info about ban ip mask bits:<br/>
					128 bits means that the exact IP(v6)-address is banned.<br/>
					24 would mean the first 24 bits would be checked, the following would not (IP-range ban).';
