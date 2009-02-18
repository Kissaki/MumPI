<?php
	require_once('settings.inc.php');
	require_once('languages/'.$lang.'.php');
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
	
	require_once($themedir.'/index.template.php');
?>
</body></html>