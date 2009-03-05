<?php
	function microtime_float()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}
	$m_scriptStart = microtime_float();
	session_start();
	
	require_once('classes/SettingsManager.php');
	require_once('classes/TranslationManager.php');
	require_once('classes/ServerInterface.php');
	require_once('classes/DBManager.php');
	
	if(SettingsManager::getInstance()->isDebugMode())
		error_reporting(E_ALL);
	
	if(isset($_GET['ajax'])){
		switch($_GET['ajax']){
			case 'getTexture':{
				
				if( isset($_GET['sid']) && isset($_GET['uid']) ){
					$texCompressed = ServerInterface::getInstance()->getUserTexture($_GET['sid'], $_GET['uid']);
					
					$texCSize = count($texCompressed);
					
					$texStr = '';
					foreach($texCompressed AS $val){
						$texStr = $texStr.$val;
					}
//					for($px=0; $px<$texCSize; $px++){
////						$texStr = $texStr.pack( 'C*', $texCompressed );
//						$texStr = $texStr.$texCompressed[$px];
//					}
					
					echo strlen($texStr).'<br/>';
					
					// TODO: this produces a data error
//					$texStr = substr($texStr, 0, strlen($texStr)-4);
					$texStr = gzuncompress($texStr);	// gzuncompress gzdecode
					
//					$file = tempnam('tmp', 'tmp');
//					file_put_contents($file, $texStr);
//					$tmpTex = gzfile($file);
//					$texStr = '';
//					foreach($tmpTex AS $val){
//						$texStr = $texStr.$val;
//					}
					
					echo strlen($texStr).'<br/>';
					
					// crc32 checksum instead of adler???
//					$f = tempnam('/tmp', 'gz_fix');
					
					$tex = unpack('C*', $texStr);
					
//					foreach(ServerInterface::getInstance()->getUserTexture($_GET['sid'], $_GET['uid']) AS $key=>$val){
//					}
//					$tex = pack( 'C*', $tex );
//					echo 'string length: '.strlen($tex).'<br/>';
//					echo 'string: '.$tex.'<br/>';
					
					$img = imagecreatetruecolor(600,60);
					$index = 1;
					
					if(imagesx($img)*imagesy($img)-count($tex) != 0)
						die('failed<br/>size x: '.imagesx($img).'<br/>size y: '.imagesy($img).'<br/>array size: '.count($tex));
					
					for($x=0; $x<imagesx($img); $x++ ){
						for($y=0; $y<imagesy($img); $y++ ){
//							imagesetpixel($img, $x, $y, imagecolorallocatealpha($img, $tex[$index], $tex[$index+1], $tex[$index+2], $tex[$index+3]) );
							$index += 4;
						}
					}
					
					header('Content-type: image/png');
					imagepng($img);
					
					
				}else{
					echo 'no image';
				}
				
				break;
			}
			
		}
		die();
	}
	
	
	//TODO: implement TranslationManager and remove this include
//	require_once('languages/'.'en'.'.php');
	
//	require_once('include/dbFunctions.inc.php');
	
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
	<title><?php echo SettingsManager::getInstance()->getSiteTitle(); ?></title>
	
	<?php require_once(SettingsManager::getInstance()->getThemeDir().'/HTMLHead.template.php'); ?>
</head>
<body>

<?php
	if(isset($_GET['section'])){
		switch($_GET['section']){
			case 'register':
				$pageSection = 'register';
				break;
			
			case 'login':
				$pageSection = 'login';
				break;
			
			case 'logout':
				// Check that visitor is logged in
				if(isset($_SESSION['userid'])){
					$pageSection = 'logout';
				}else{	// not logged in -> send to index
					header('Location: ./');
					echo '<script type="text/javascript">location.replace("./")</script>';
					echo 'Successfull logout.<br/>go <a href="./">here</a>';
					$pageSection = 'index';
				}
				break;
			
			case 'profile':
				// Check that visitor is logged in
				if(isset($_SESSION['userid'])){
					$pageSection = 'profile';
				}else{	// not logged in -> send to index
					header('Location: ./');
					echo '<script type="text/javascript">location.replace("./")</script>';
					echo 'Not logged in.<br/>go <a href="./">here</a>';
					$pageSection = 'index';
				}
				break;
			
			case 'request':
				$pageSection = 'request';
				break;
			
			default:
				$pageSection = 'index';
		}
	}else{
		$pageSection = 'index';
	}
	
	// Parse Template
	require_once(SettingsManager::getInstance()->getThemeDir().'/header.template.php');
	require_once(SettingsManager::getInstance()->getThemeDir().'/'.$pageSection.'.template.php');
	require_once(SettingsManager::getInstance()->getThemeDir().'/footer.template.php');
	
?>
</body></html>