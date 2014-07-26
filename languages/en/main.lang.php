<?php
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
	$txt['admin_area'] = 'Admin';
	$txt['permission_denied'] = 'Permission denied.';

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
	$txt['error_noIceExtensionLoaded']	= 'It seems your PHP configuration is not running with the Ice extension.<br/>Please set up your PHP to load the Ice extension.<br/><br/>Ice is the middleware between <acronym title="Mumble Server">Murmur</acronym> and PHP/the Interface, allowing PHP to call Murmur functions. Thus, this is necessary.<br/>For introductions on how to set it up, see <a href="http://mumble.sourceforge.net/Ice">mumble.sf.net/Ice</a>.';
	$txt['error_noIceSliceLoaded']			= 'It seems your PHP configuration does not know the necessary slice file.<br/>For introductions on how to set it up, see <a href="http://mumble.sourceforge.net/Ice">mumble.sf.net/Ice</a>.<br/><br/>The slice file tells PHP which methods and data are available to PHP, to access <acronym title="Mumble Server">Murmur</acronym>.';
	$txt['error_noIce']									= 'Could not connect to Ice.<br/>Either your server is not running or it is not running with Ice. Check your configuration.';
	$txt['error_iceConnectionRefused']	= 'Could not connect to Ice.<br/>Either your server is not running or it is not running with Ice. Check your configuration.';
	$txt['error_unknowninterface']			= 'Misconfiguration: Unknown <acronym title="database">DB</acronym> Interface Type!';
	$txt['error_iceInclusionFileNotFound'] = 'The Ice.php file could not be found. Please make sure the ice php file inclusion dir is in the phps include_path (check your PHP configuration).<br/><br/>E.g., if you are using php-fpm and php-zeroc-ice on Ubuntu 14.04:<br/>Open the php.ini: <code>sudo vim php5/fpm/php.ini</code><br/>And adjust the include path: <code>include_path = ".:/usr/share/Ice-3.5.1/php/lib"</code><br/><br/>The current include path is: <code>' . get_include_path() . '</code>';
	$txt['error_iceMurmurPHPFileNotFound'] = 'The generated Murmur.php file that was configured to be used was not found. The file is generated from the mumble server slice definition file, and some are provided with MumPI (see files <code>classes/Murmur_<em>[…]</em>.php</code>). The file that is to be used is specified via the settingvariable <code>$iceGeneratedMurmurPHPFileName</code> in the MumPI <code>settings.inc.php</code> file.';
	$txt['unknownserver']								= 'No such server found.';
	$txt['error_missing_values']				= 'It seems not all necessary values have been specified.';
	$txt['error_db_unknowntype']				= 'The Database type you specified (in your settings) is not available/defined.';
	$txt['iceprofilealreadyloaded'] 		= 'Ice Profile has already been loaded!';
	$txt['error_dbmanager_couldnotopenadmins'] = 'Could not open admins.dat file.';
	$txt['error_invalidTexture']				= 'Invalid image data. Please check your image file.';
	$txt['login_missing_data'] 					= 'Login failed: You did not seem to provide all the necessary data.';
	$txt['error_invalidIceInterface_address'] = 'The configured Ice interface address could not be parsed. Please make it a valid address.';
