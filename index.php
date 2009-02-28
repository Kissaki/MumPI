<?php
	session_start();
	require_once('settings.inc.php');
	require_once('classes/SettingsManager.php');
	require_once('classes/TranslationManager.php');
	
	//TODO: implement TranslationManager and remove this include
//	require_once('languages/'.'en'.'.php');
	
	require_once('classes/ServerDatabase.php');
	
	require_once('include/dbFunctions.inc.php');
	
?>
<?php	// TODO: implement login check and remove this php part
	$visitor['loggedIn'] = false;
	if(isset($_GET['loggedIn']) && $_GET['loggedIn'] == 'true') $visitor['loggedIn'] = true;
	$visitor['name'] = 'foobar-user';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="<?php echo SettingsManager::getInstance()->getSiteDescription(); ?>" />
	<meta name="keywords" content="<?php echo SettingsManager::getInstance()->getSiteKeywords(); ?>" />
	<title><?php echo $muPI_site['title']; ?></title>
	
	<?php require_once(SettingsManager::getInstance()->getThemeDir().'/HTMLHead.template.php'); ?>
</head>
<body>

<?php
	if(isset($_GET['section']))
		switch($_GET['section']){
			case 'register':
				$pageSection = 'register';
				break;
			
			case 'login':
				$pageSection = 'login';
				break;
			
			case 'logout':
				// Check that visitor is logged in
				if(isset($_SESSION['userid']))
					$pageSection = 'logout';
				else	// not logged in -> send to index
					header('Location: ./');
				break;
			
			case 'profile':
				// Check that visitor is logged in
				if(isset($_SESSION['userid']))
					$pageSection = 'profile';
				else	// not logged in -> send to index
					header('Location: ./');
				break;
			
			default:
				$pageSection = 'index';
		}
	else
		$pageSection = 'index';
	
	// Parse Template
	require_once(SettingsManager::getInstance()->getThemeDir().'/header.template.php');
	require_once(SettingsManager::getInstance()->getThemeDir().'/'.$pageSection.'.template.php');
	require_once(SettingsManager::getInstance()->getThemeDir().'/footer.template.php');
	
?>
</body></html>