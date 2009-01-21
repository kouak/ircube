<?php 
/* SVN FILE: $Id$ */
/* NewsController Test cases generated on: 2008-09-26 00:09:54 : 1222383054*/
App::import('Controller', 'News');

class TestNews extends NewsController {
	var $autoRender = false;
}

class NewsControllerTest extends CakeTestCase {
	var $News = null;

	function setUp() {
		$this->News = new TestNews();
	}

	function testNewsControllerInstance() {
		$this->assertTrue(is_a($this->News, 'NewsController'));
	}

	function tearDown() {
		unset($this->News);
	}
}
?>