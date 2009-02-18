<?php

require_once('simpletest/autorun.php');
require_once('../classes/MurmurClasses.php');

class TestOfUserAccount extends UnitTestCase {
	function testUserAccountObjectCreated() {
        $obj = new UserRegistration();
        $this->assertTrue($obj->returnTrue());
    }
	
}

?>
