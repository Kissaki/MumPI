<?php
/**
 * Provides database functionality for the interface
 * @author Kissaki
 */
class DBManager{
	private static $instance;
	public static function getInstance($obj=NULL){
		if(!isset(self::$instance)){
			if(isset($obj)){
				self::$instance = $obj;
			}else{
				$dbType = SettingsManager::getInstance()->getDBType();
				if( class_exists('DBManager_'.$dbType) )
					eval('self::$instance = new DBManager_'.$dbType.'();');
				else
					echo TranslationManager::getInstance()->getText('error_db_unknowntype');	// TODO: add this error msg to lang
			}
		}
		return self::$instance;
	}
}

class DBManager_filesystem{
	function __construct(){
		// if data dir does not exist yet, create it
		if(!file_exists(SettingsManager::getInstance()->getMainDir().'/data')){
			mkdir(SettingsManager::getInstance()->getMainDir().'/data');
		}
		// if data files do not exist yet, create them
		if(!file_exists(SettingsManager::getInstance()->getMainDir().'/data/awaiting.dat')){
			fclose( fopen(SettingsManager::getInstance()->getMainDir().'/data/awaiting.dat','w') );
		}
	}
	
	/**
	 * Add an account awaiting activation/authentification.
	 * @param $sid	ServerID
	 * @param $name	Username
	 * @param $pw	Password
	 * @param $email email address
	 */
	public function addAwaitingAccount($sid, $name, $pw, $email){
		$fd = fopen(SettingsManager::getInstance()->getMainDir().'/data/awaiting.dat', 'a') OR die('could not open DB file');
		
		// Make sure the activation code is explicit
		do{
			$key = (string)md5(rand());
		}while( $this->getAwaitingAccount($key)!=null );
		
		// TODO: is this even allowed? ";" in name or pw
		$name = str_replace(';', '/;/', $name);
		$pw = str_replace(';', '/;/', $pw);
		$line = $key.';;;'.$sid.';;;'.$name.';;;'.$pw.';;;'.$email."\n";
		fwrite($fd, $line);
		fclose($fd);
		// TODO: add localisation strings
		mail($name.' <'.$email.'>', 'Account Activation', 'You tried to register an account on '.SettingsManager::getInstance()->getSiteTitle().' ('.
			SettingsManager::getInstance()->getMainUrl().') on the server '.SettingsManager::getInstance()->getServerName($sid).
			".\n".'To activate your account open the following link in your browser:'."\n".
			SettingsManager::getInstance()->getMainUrl().'?section=register&action=activate&key='.$key."\n".
			'Then you may log in on the mumble server.');
	}
	
	/**
	 * Try to activate an account with the given activation key
	 * @param $key
	 */
	function activateAccount($key){
		$acc = $this->getAwaitingAccount($key);
		if($acc!=null){
			try{
				ServerInterface::getInstance()->addUser($acc['sid'], $acc['name'], $acc['pw'], $acc['email']);
				$this->removeAwaitingAccount($key);
			}catch(Exception $exc){
				
			}
		}else{
			echo '<div class="error">unknown activation key</div>';
		}
	}
	function getAwaitingAccount($key){
		$fd = fopen(SettingsManager::getInstance()->getMainDir().'/data/awaiting.dat', 'r') OR die('could not open DB file');
		while($line = fgets($fd)){
			if(substr($line, 0, 32)==$key){
				$line = explode(';;;', $line);
				foreach($line as $key=>$val){
					$line[$key] = str_replace('/;/', ';', $val);
				}
				
				$acc = array();
				$acc['key'] =	$line[0];
				$acc['sid'] =	$line[1];
				$acc['name'] =	$line[2];
				$acc['pw']	=	$line[3];
				$acc['email'] =	str_replace("\n", '', $line[4]);
				
				fclose($fd);
				return $acc;
			}
		}
		fclose($fd);
		return null;
	}
	public function removeAwaitingAccount($key){
		$filename = SettingsManager::getInstance()->getMainDir().'/data/awaiting.dat';
		$file = file_get_contents($filename);
		$file = preg_replace('/'.$key.';;;(.+)\n/', '', $file);
		file_put_contents($filename, $file);
	}
	
}

// TODO: implement MySQL
//class DBManager_mysql{

// TODO: implement PostgreSQL
//class DBManager_psql{

?>