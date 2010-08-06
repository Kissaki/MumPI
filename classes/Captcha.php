<?php
class Captcha
{
	public static function cap_show()
	{
		$mainDir = SettingsManager::getInstance()->getMainDir();
		if (!file_exists($mainDir.'/tmp')) {
			mkdir($mainDir.'/tmp');
		}
		$filename = 'cap_'.rand(44,888888).'.png';
		$op[0] = '+';
		$op[1] = '-';
		$cap_r1 = rand(0,99);
		$cap_op = $op[rand(0,1)];
		$cap_r2 = rand(0,22);
		eval('$cap_result = '.$cap_r1.$cap_op.$cap_r2.';');
		$_SESSION['captcha_result'] = md5($cap_result);

		$img = imagecreatetruecolor(50, 30);
		imagettftext($img, 12, rand(-30,30), 2, 20, imagecolorexact($img,rand(150,255),rand(150,255),rand(150,255)), $mainDir.'/resources/arial.ttf', $cap_r1);
		imagettftext($img, 12, rand(-15,15), 20, 20, imagecolorexact($img,rand(150,255),rand(150,255),rand(150,255)), $mainDir.'/resources/arial.ttf', $cap_op);
		imagettftext($img, 12, rand(-35,35), 30, 20, imagecolorexact($img,rand(150,255),rand(150,255),rand(150,255)), $mainDir.'/resources/arial.ttf', $cap_r2);
		imagepng($img, $mainDir.'/tmp/'.$filename);
		imagedestroy($img);
		echo '<img src="'.SettingsManager::getInstance()->getMainUrl().'/tmp/'.$filename.'" alt=""/>';
		self::cap_cleanup();
	}

	public static function cap_isCorrect($val)
	{
		if (md5($val) == $_SESSION['captcha_result']) {
			unset($_SESSION['captcha_result']);
			self::cap_cleanup();
			return true;
		} else {
			return false;
		}
	}

	public static function cap_cleanup()
	{
		$files = glob(SettingsManager::getInstance()->getMainDir().'/tmp/*');
		foreach ($files as $filename) {
			if (filectime($filename) < time()-300) {
				unlink($filename);
			}
		}
	}
}
