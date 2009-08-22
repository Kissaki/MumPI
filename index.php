<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */

	if (!file_exists('settings.inc.php')) {
		header('Location: ./install');
	} else {
		header('Location: ./user');
	}
?>