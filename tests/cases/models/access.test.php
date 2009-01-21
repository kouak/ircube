<?php 
/* SVN FILE: $Id$ */
/* Access Test cases generated on: 2008-09-24 21:09:48 : 1222284288*/
App::import('Model', 'Access');

class TestAccess extends Access {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class AccessTestCase extends CakeTestCase {
	var $Access = null;
	var $fixtures = array('app.access', 'app.channel', 'app.user');

	function start() {
		parent::start();
		$this->Access = new TestAccess();
	}

	function testAccessInstance() {
		$this->assertTrue(is_a($this->Access, 'Access'));
	}

	function testAccessFind() {
		$results = $this->Access->recursive = -1;
		$results = $this->Access->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Access' => array(
			'id'  => 1,
			'flag'  => 1,
			'created'  => '2008-09-24 21:24:48',
			'modified'  => '2008-09-24 21:24:48',
			'lastseen'  => '2008-09-24 21:24:48',
			'channel_id'  => 1,
			'user_id'  => 1,
			'channel_name'  => 'Lorem ipsum dolor sit amet',
			'user_name'  => 'Lorem ipsum dolor sit amet',
			'level'  => 1,
			'info'  => 'Lorem ipsum dolor sit amet'
			));
		$this->assertEqual($results, $expected);
	}
}
?>