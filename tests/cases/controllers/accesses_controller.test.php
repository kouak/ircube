<?php 
/* SVN FILE: $Id$ */
/* AccessesController Test cases generated on: 2008-09-24 21:09:26 : 1222284806*/
App::import('Controller', 'Accesses');

class TestAccesses extends AccessesController {
	var $autoRender = false;
}

class AccessesControllerTest extends CakeTestCase {
	var $Accesses = null;

	function setUp() {
		$this->Accesses = new TestAccesses();
	}

	function testAccessesControllerInstance() {
		$this->assertTrue(is_a($this->Accesses, 'AccessesController'));
	}

	function tearDown() {
		unset($this->Accesses);
	}
}
?>