<?php 
/* SVN FILE: $Id$ */
/* Memo Test cases generated on: 2008-09-24 21:09:52 : 1222283872*/
App::import('Model', 'Memo');

class TestMemo extends Memo {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class MemoTestCase extends CakeTestCase {
	var $Memo = null;
	var $fixtures = array('app.memo', 'app.user');

	function start() {
		parent::start();
		$this->Memo = new TestMemo();
	}

	function testMemoInstance() {
		$this->assertTrue(is_a($this->Memo, 'Memo'));
	}

	function testMemoFind() {
		$results = $this->Memo->recursive = -1;
		$results = $this->Memo->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Memo' => array(
			'id'  => 1,
			'user_id'  => 1,
			'sender_id'  => 1,
			'created'  => 1,
			'lastupdated'  => 1,
			'flag'  => 1,
			'sender'  => 'Lorem ipsum dolor sit amet',
			'content'  => 'Lorem ipsum dolor sit amet'
			));
		$this->assertEqual($results, $expected);
	}
}
?>