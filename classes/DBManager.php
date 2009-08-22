<?php
/**
 * Mumble PHP Interface by Kissaki
 * Released under Creative Commons Attribution-Noncommercial License
 * http://creativecommons.org/licenses/by-nc/3.0/
 * @author Kissaki
 */

require_once(MUMPHPI_MAINDIR.'/classes/SettingsManager.php');
require_once(MUMPHPI_MAINDIR.'/classes/MessageManager.php');
require_once(MUMPHPI_MAINDIR.'/classes/TranslationManager.php');

/**
 * Provides database functionality for the interface
 * @author Kissaki
 */
class DBManager
{
	private static $instance;
	public static function getInstance()
	{
		if(!isset(self::$instance) || self::$instance == null)
		{
			$dbType = SettingsManager::getInstance()->getDBType();
			if( class_exists('DBManager_'.$dbType) )
				eval('self::$instance = new DBManager_'.$dbType.'();');
			else
				MessageManager::addError(tr('error_db_unknowntype'));
		}
		return self::$instance;
	}
}

class DBManager_filesystem {
	private static $filename_admins = 'admins.dat';
	
	private $filepath_admins;
	private $filepath_awaiting;
	private $filepath_log_register;
	
	function __construct(){
		$this->filepath_admins = SettingsManager::getInstance()->getMainDir().'/data/'.self::$filename_admins;
		$this->filepath_awaiting = SettingsManager::getInstance()->getMainDir().'/data/awaiting.dat';
		$this->filepath_log_register = SettingsManager::getInstance()->getMainDir().'/data/log_register.log';
		
		// if data dir does not exist yet, create it
		if(!file_exists(SettingsManager::getInstance()->getMainDir().'/data')){
			mkdir(SettingsManager::getInstance()->getMainDir().'/data');

			// if data files do not exist yet, create them
			if(!file_exists($this->filepath_awaiting)){
				fclose( fopen($this->filepath_awaiting,'w') );
			}
			if(!file_exists($this->filepath_log_register)){
				fclose( fopen($this->filepath_log_register,'w') );
			}
			if(!file_exists($this->filepath_admins)){
				fclose( fopen($this->filepath_admins,'w') );
			}
			
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
		
		// TODO: is this even allowed? ";" in name?
		$name = str_replace(';', '/;/', $name);
		// TODO: pw should be saved as hash here as well
		$pw = str_replace(';', '/;/', $pw);
		$line = $key.';;;'.$sid.';;;'.$name.';;;'.$pw.';;;'.$email."\n";
		fwrite($fd, $line);
		fclose($fd);
		
		// send mail
		$this->sendActivationMail($email, $name, $sid, $key);
	}
	public function sendActivationMail($email, $name, $sid, $key){
		mail(
			$email,											// to
			tr('register_mail_auth_subj'),						// subject
			sprintf( tr('register_mail_auth_body'),				// body...
				SettingsManager::getInstance()->getSiteTitle(),
				HelperFunctions::getBaseURL(),
				SettingsManager::getInstance()->getServerName($sid),
				HelperFunctions::getBaseURL(),
				$key
				),												// ...body
			'Content-Type: text/plain; charset="UTF-8"'			// +header
			);
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
	
	/**
	 * Write a message to a specific file.
	 * @param $filename
	 * @param $msg
	 */
	public function append($field, $msg){
		$fd = fopen(SettingsManager::getInstance()->getMainDir().'/data/'.$field, 'a') OR die('could not open DB file');
		fwrite($fd, $msg."\n");
		fclose($fd);
	}
	
	public function addAdminLogin($username, $password, $isGlobalAdmin=false){
		if($this->getAdminByName($username)==null)
		{
			$fd = fopen(SettingsManager::getInstance()->getMainDir().'/data/'.self::$filename_admins, 'a');
			fwrite($fd, sprintf("%s;%s;%s;%s\n", $this->getNextAdminID(), $username, sha1($password), $isGlobalAdmin));
			fclose($fd);
		}else{
			MessageManager::addError(tr('error_AdminAccountAlreadyExists'));
		}
	}
	public function removeAdminLogin($id){
		$data = file($this->filepath_admins);
		$fd = fopen($this->filepath_admins, 'w');
		$size = count($data);
		
		for($line=0; $line<$size; $line++)
		{
			$array = explode(';', $data[$line]);
			if( $array[0] != $id ){ fputs($fd, $data[$line]); }
		}
		fclose($fd);
	}
	/**
	 * 
	 * @return array of admins, with id, name, pw
	 */
	public function getAdmins(){
		$fd = fopen($this->filepath_admins, 'r') OR MessageManager::addError('could not open '.self::$filename_admins.' file');
		$admins = array();
		$id = 0;
		while($line = fgets($fd)){
			$array = explode(';', $line);
			$lastindex = count($array)-1;
			$array[$lastindex] = substr($array[$lastindex], 0, strlen($array[$lastindex])-1);
			$admin['id'] = $array[0];
			$admin['name'] = $array[1];
			$admin['pw'] = $array[2];
			$admins[] = $admin;
		}
		$id++;
		fclose($fd);
		return $admins;
	}
	public function getAdminByName($username){
		if(file_exists($this->filepath_admins))
		{
			$fd = fopen($this->filepath_admins, 'r') OR MessageManager::addError('could not open '.self::$filename_admins.' file');
			while($line = fgets($fd)){
				$array = explode(';', $line);
				if( $array[1] == $username )
				{
					$lastindex = count($array)-1;
					$array[$lastindex] = substr($array[$lastindex], 0, strlen($array[$lastindex])-1);
					$admin['id'] = $array[0];
					$admin['name'] = $array[1];
					$admin['pw'] = $array[2];
					$admin['isGlobal'] = $array[3];
					fclose($fd);
					return $admin;
				}
			}
		}
		return null;
	}
	/**
	 * Get the next free ID for an admin
	 * @return int
	 */
	public function getNextAdminID(){
		$admins = $this->getAdmins();
		// Get the maximum ID in use
		$maxid = 0;
		foreach($admins AS $admin)
		{
			$maxid < $admin['id'] ? $maxid = $admin['id'] : void ; 
		}
		// The next free ID is the maximum one +1
		return $maxid+1;
	}
	public function checkAdminLogin($username, $password){
		$admin = $this->getAdminByName($username);
		if( $admin != null && ( $admin['pw'] == $password || $admin['pw'] == sha1($password)) ){
			return true;
		}
		if(!file_exists($this->filepath_admins))
		{
			$this->addAdminLogin($username, $password);
			return true;
		}
		return false;
	}
	
}

// TODO: implement MySQL
//class DBManager_mysql{

// TODO: implement PostgreSQL
//class DBManager_psql{

// TODO: implement sqlite
//class DBManager_sqlite{

?>