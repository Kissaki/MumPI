<?php
	define('MUMPHPI_MAINDIR', '..');
	define('MUMPHPI_SECTION', 'install');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8" />

	<title>MumPI – Installation</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
</head>
<body>
<?php
	if (!is_writable('../')) {
		echo 'The main interface folder <b>is not writable</b> (for this PHP instance).<br/>';
		echo '<b>Please adjust</b> the folder permissions to be writable.';
		echo '</body></html>';
		exit();
	}
	if (file_exists('../data') && !is_writable('../data')) {
		echo 'The data folder does exist but <b>is not writable</b> (for this PHP instance).<br/>';
		echo '<b>Please adjust</b> the folder permissions to be writable.<br/>';
		echo 'Please also add write permission to the files inside the data folder.<br/>';
		echo '</body></html>';
		exit();
	}
	if (file_exists('../tmp') && !is_writable('../tmp')) {
		echo 'The tmp folder does exist but <b>is not writable</b> (for this PHP instance).<br/>';
		echo '<b>Please adjust</b> the folder permissions to be writable.';
		echo '</body></html>';
		exit();
	}
	if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()==1) {
		echo 'Your PHP configuration has <i>magic quotes</i> enabled, however this is <b>discouraged</b> and may cause problems sending data to the interface (for example adding links to the servers welcome message).';
		echo 'Please disable it in your PHP configuration or ask your host to do so.';
		echo 'Magic quotes are <a href="http://de.php.net/manual/en/info.configuration.php#ini.magic-quotes-gpc">depreciated as of PHP 5.3 and removed in PHP 6</a>. And that’s for a reason. :)';
		echo '<br/><br/>';
	}

	// create settings file
	if (!file_exists('../settings.inc.php')) {
		echo 'settings.inc.php file not found.<br/>';
		if (!file_exists('../settings.inc.default.php')) {
			echo 'Could not find the default settings file named <i>settings.inc.default.php</i>.<br/>
				Please check your installation/extraction. It has to be placed in your main interface folder.<br/>';
		} else {
			file_put_contents('../settings.inc.php', file_get_contents('../settings.inc.default.php'));
			echo 'Used the default settings file to create one.<br/>';
		}
	} else {
		echo '<i>settings.inc.php</i> seems to be in place. Skipping…<br/>';
	}
	echo '<br/>';

	// handle admins.dat file
	if (file_exists('../data/admins.dat')) {
		$fh = fopen('../data/admins.dat', 'r+');
		$line = fgets($fh);

		if (count(split(';', $line)) == 2) {
			// convert old to new format
			echo '<i>admins.dat</i> in old format.<br/>';
			echo 'Converting…<br/>';
			$newfile = '';
			$id = 1;

			do {
				$admin = split(';', $line);
				$newfile .= $id . ';' . $admin[0] . ';' . substr($admin[1], 0, strlen($admin[1])-1) . ';' . '1' . "\n";
				$id++;
			} while ($line = fgets($fh));
			fclose($fh);
			file_put_contents('../data/admins.dat', $newfile);
			echo '<i>admins.dat</i> has been converted to the new format.<br/>';
		} else {
			fclose($fh);
			echo '<i>admins.dat</i> does not have to be converted.';
		}
	} else {
		fclose(fopen('../data/admins.dat', 'w'));
		echo '<i>admins.dat</i> created.';
	}
	echo '<br/>';

	if (!file_exists('../data/admin_groups.dat')) {
		echo 'creating admin groups file…<br/>';
		fclose(fopen('../data/admin_groups.dat', 'w'));
	}
	if (!file_exists('../data/admin_group_permissions.dat')) {
		echo 'creating admin group permissions file…<br/>';
		fclose(fopen('../data/admin_group_permissions.dat', 'w'));
	}
	if (!file_exists('../data/admin_group_assoc.dat')) {
		echo 'creating admin group assoc file…<br/>';
		fclose(fopen('../data/admin_group_assoc.dat', 'w'));
	}
	if (!file_exists('../data/admin_group_server_assoc.dat')) {
		echo 'creating admin group server assoc file…<br/>';
		fclose(fopen('../data/admin_group_server_assoc.dat', 'w'));
	}
?>
	<p>
		<b>You’re done.</b><br/>
		You may now want to further configure your server(s) and the interface in the <a href="../admin/">admin section</a>,<br/>
		or go straight to the <a href="../user/">user section</a>.
	</p>
</body></html>