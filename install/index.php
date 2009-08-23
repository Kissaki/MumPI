<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */

define('MUMPHPI_MAINDIR', '..');
define('MUMPHPI_SECTION', 'install');

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
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
		echo '<i>admins.dat</i> does not have to be converted.';
	}
	echo '<br/>';
	
?>
	<p>
		<b>You’re done.</b><br/>
		You may now want to further configure your server(s) and the interface in the <a href="../admin/">admin section</a>,<br/>
		or go straight to the <a href="../user/">user section</a>.
	</p>
</body></html>