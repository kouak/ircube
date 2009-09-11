<?php 
/* SVN FILE: $Id$ */
/* Access Test cases generated on: 2009-08-31 17:08:05 : 1251732845*/
App::import('Model', 'Access');

class AccessTestCase extends CakeTestCase {
	var $Access = null;
	var $fixtures = array('app.access', 'app.channel', 'app.user');

	function startTest() {
		$this->Access =& ClassRegistry::init('Access');
	}

	function testAccessInstance() {
		$this->assertTrue(is_a($this->Access, 'Access'));
	}

	function testAccessFind() {
		$this->Access->recursive = -1;
		$results = $this->Access->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Access' => array(
			'id'  => 1,
			'flag'  => 1,
			'modified'  => '2009-08-31 17:34:02',
			'lastseen'  => '2009-08-31 17:34:02',
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