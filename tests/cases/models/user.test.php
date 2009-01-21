<?php 
/* SVN FILE: $Id$ */
/* User Test cases generated on: 2008-09-24 21:09:06 : 1222283706*/
App::import('Model', 'User');

class TestUser extends User {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class UserTestCase extends CakeTestCase {
	var $User = null;
	var $fixtures = array('app.user', 'app.access', 'app.memo');

	function start() {
		parent::start();
		$this->User = new TestUser();
	}

	function testUserInstance() {
		$this->assertTrue(is_a($this->User, 'User'));
	}

	function testUserFind() {
		$results = $this->User->recursive = -1;
		$results = $this->User->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('User' => array(
			'id'  => 1,
			'username'  => 'Lorem ipsum dolor sit amet',
			'password'  => 'Lorem ipsum do',
			'level'  => 1,
			'flag'  => 1,
			'lastseen'  => '2008-09-24 21:15:06',
			'modified'  => '2008-09-24 21:15:06',
			'created'  => '2008-09-24 21:15:06',
			'mail'  => 'Lorem ipsum dolor sit amet',
			'lang'  => 'Lorem ipsum dolor sit amet',
			'lastlogin'  => 'Lorem ipsum dolor sit amet'
			));
		$this->assertEqual($results, $expected);
	}
}
?>