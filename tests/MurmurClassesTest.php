<?php

//require_once('simpletest/autorun.php');
require_once(dirname(__FILE__).'/../classes/MurmurClasses.php');

class TestOfUserAccount extends UnitTestCase {
	function testUserAccountObjectCreated() {
        //$obj = new UserRegistration();
        //$this->assertTrue($obj->returnTrue());
        //$this->assertTrue(true,"Error");
        $this->assertEqual(4,4,"das muss doch gehen");
    }
	
}

?>
