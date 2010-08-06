<?php
/**
 * Ajax functionality
 * @author Kissaki
 */

require_once dirname(__FILE__).'/ajax.ajax.php';

//TODO make it a class “Ajax_User”, like Ajax_Admin

// TODO getTexture does not work (yet). Remove or fix.
//		This seems to be a problem with decompressing the string, gzuncompress() does not work, gzdecode() is PHP 6
		switch ($_GET['ajax']) {
			case 'getTexture':{

				if (isset($_GET['sid']) && isset($_GET['uid'])) {
					$texCompressed = ServerInterface::getInstance()->getUserTexture($_GET['sid'], $_GET['uid']);

					$texCSize = count($texCompressed);

					$texStr = '';
					foreach ($texCompressed AS $val) {
						$texStr = $texStr.$val;
					}
//					for ($px=0; $px<$texCSize; $px++) {
////						$texStr = $texStr.pack( 'C*', $texCompressed );
//						$texStr = $texStr.$texCompressed[$px];
//					}

					echo strlen($texStr).'<br/>';

//					$texStr = substr($texStr, 0, strlen($texStr)-4);
					$texStr = gzuncompress($texStr);	// gzuncompress gzdecode

//					$file = tempnam('tmp', 'tmp');
//					file_put_contents($file, $texStr);
//					$tmpTex = gzfile($file);
//					$texStr = '';
//					foreach ($tmpTex AS $val) {
//						$texStr = $texStr.$val;
//					}

					echo strlen($texStr).'<br/>';

					// crc32 checksum instead of adler???
//					$f = tempnam('/tmp', 'gz_fix');

					$tex = unpack('C*', $texStr);

//					foreach (ServerInterface::getInstance()->getUserTexture($_GET['sid'], $_GET['uid']) AS $key=>$val) {
//					}
//					$tex = pack( 'C*', $tex );
//					echo 'string length: '.strlen($tex).'<br/>';
//					echo 'string: '.$tex.'<br/>';

					$img = imagecreatetruecolor(600,60);
					$index = 1;

					if (imagesx($img)*imagesy($img)-count($tex) != 0) {
						die('failed<br/>size x: '.imagesx($img).'<br/>size y: '.imagesy($img).'<br/>array size: '.count($tex));
					}

					for ($x=0; $x<imagesx($img); $x++) {
						for ($y=0; $y<imagesy($img); $y++) {
//							imagesetpixel($img, $x, $y, imagecolorallocatealpha($img, $tex[$index], $tex[$index+1], $tex[$index+2], $tex[$index+3]) );
							$index += 4;
						}
					}

					header('Content-type: image/png');
					imagepng($img);

				} else {
					echo 'no image';
				}

				break;
			} // /case

		} // /switch
