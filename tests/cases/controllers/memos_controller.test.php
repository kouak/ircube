<?php 
/* SVN FILE: $Id$ */
/* MemosController Test cases generated on: 2008-09-24 21:09:55 : 1222283935*/
App::import('Controller', 'Memos');

class TestMemos extends MemosController {
	var $autoRender = false;
}

class MemosControllerTest extends CakeTestCase {
	var $Memos = null;

	function setUp() {
		$this->Memos = new TestMemos();
	}

	function testMemosControllerInstance() {
		$this->assertTrue(is_a($this->Memos, 'MemosController'));
	}

	function tearDown() {
		unset($this->Memos);
	}
}
?>