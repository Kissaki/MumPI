<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */
/**
 * This is the main language file, containing general strings that will be used in more than one section
 */

	// General Functions
	$txt['edit'] = 'edit';			// Edit something
	$txt['cancel'] = 'cancel';		// Cancel, whatever you're doing (go back to the last page).
	$txt['update'] = 'update';		// Update the old item/key/var. Use the entered values as new values.
	$txt['remove'] = 'remove';
	
	// General
	$txt['server'] = 'Server';		// Mumble Server
	$txt['info_serverversion'] = 'Server Version: %s';
	$txt['info_scriptexecutiontime'] = 'Script execution time: %6.3fms | memory peak: ~%s kByte';
	$txt['failed'] = 'failed';
	
	// Account Information
	$txt['email'] = 'Email';
	$txt['username'] = 'Username';
	$txt['password'] = 'Password';
	$txt['texture'] = 'User Image';
	$txt['userid'] = 'User ID';
	
	$txt['texture_none'] = 'no image';
	$txt['texture_set'] = 'image set';
	
	// Profile
	$txt['help_profile_textur'] = 'This user texture will be displayed in mumbles overlay instead of a nickname, if activated in the options.';
	
	//Errors
	$txt['error_unknowninterface']	= 'Misconfiguration: Unknown <acronym title="database">DB</acronym> Interface Type!';
	$txt['unknownserver']				= 'No such server found.';
	$txt['error_missing_values']		= 'It seems not all necessary values have been specified.';
	$txt['error_noIce']					= 'Could not connect to ICE.<br/>Either your server is not running or it is not running with ICE. Check your configuration.';
	$txt['error_db_unknowntype']		= 'The Database type you specified (in your settings) is not available/defined.';
	$txt['iceprofilealreadyloaded'] = 'ICE Profile Already Loaded!';
	$txt['error_dbmanager_couldnotopenadmins'] = 'could not open admins.dat file';

?>