<?php 
/* SVN FILE: $Id$ */
/* QuotesController Test cases generated on: 2009-08-26 17:08:18 : 1251301398*/
App::import('Controller', 'Quotes');

class TestQuotes extends QuotesController {
	var $autoRender = false;
}

class QuotesControllerTest extends CakeTestCase {
	var $Quotes = null;

	function startTest() {
		$this->Quotes = new TestQuotes();
		$this->Quotes->constructClasses();
	}

	function testQuotesControllerInstance() {
		$this->assertTrue(is_a($this->Quotes, 'QuotesController'));
	}

	function endTest() {
		unset($this->Quotes);
	}
}
?>