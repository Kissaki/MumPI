<?php

class myGroupTest extends GroupTest {
  function myGroupTest() {
    parent::GroupTest('');
    $this->addTestFile(dirname(__FILE__).'/MurmurClassesTest.php');
    //$this->addTestFile(dirname(__FILE__).'/test2.php');
  }
}

?>
