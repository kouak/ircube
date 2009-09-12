<?php 
/* SVN FILE: $Id$ */
/* NewsCommentsController Test cases generated on: 2009-06-18 16:06:51 : 1245335751*/
App::import('Controller', 'NewsComments');

class TestNewsComments extends NewsCommentsController {
	var $autoRender = false;
}

class NewsCommentsControllerTest extends CakeTestCase {
	var $NewsComments = null;

	function startTest() {
		$this->NewsComments = new TestNewsComments();
		$this->NewsComments->constructClasses();
	}

	function testNewsCommentsControllerInstance() {
		$this->assertTrue(is_a($this->NewsComments, 'NewsCommentsController'));
	}

	function endTest() {
		unset($this->NewsComments);
	}
}
?>