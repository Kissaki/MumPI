<?php
	require_once('settings.inc.php');
	require_once('languages/'.$lang.'.php');
?>
<?php	// TODO: implement login check and remove this php part
	$visitor['loggedIn'] = false;
	if(isset($_GET['loggedIn']) && $_GET['loggedIn'] == 'true') $visitor['loggedIn'] = true;
	$visitor['name'] = 'foobar-user';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="description" content="<?php echo $site['description']; ?>" />
	<meta name="keywords" content="<?php echo $site['keywords']; ?>" />
	<title><?php echo $site['title']; ?></title>
	
	<?php require_once($themedir.'/headerInclude.template.php'); ?>
	
	<!--<script language="JavaScript" type="text/javascript">
	</script>-->
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
				$pageSection = 'logout';
				break;
			
			default:
				$pageSection = 'index';
		}
	else
		$pageSection = 'index';
	require_once($themedir.'/'.$pageSection.'.template.php');
?>
</body></html>