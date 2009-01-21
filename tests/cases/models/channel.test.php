<?php 
/* SVN FILE: $Id$ */
/* Channel Test cases generated on: 2008-09-24 21:09:47 : 1222284227*/
App::import('Model', 'Channel');

class TestChannel extends Channel {
	var $cacheSources = false;
	var $useDbConfig  = 'test_suite';
}

class ChannelTestCase extends CakeTestCase {
	var $Channel = null;
	var $fixtures = array('app.channel', 'app.access');

	function start() {
		parent::start();
		$this->Channel = new TestChannel();
	}

	function testChannelInstance() {
		$this->assertTrue(is_a($this->Channel, 'Channel'));
	}

	function testChannelFind() {
		$results = $this->Channel->recursive = -1;
		$results = $this->Channel->find('first');
		$this->assertTrue(!empty($results));

		$expected = array('Channel' => array(
			'id'  => 1,
			'channel'  => 'Lorem ipsum dolor sit amet',
			'flag'  => 1,
			'modified'  => '2008-09-24 21:23:47',
			'created'  => '2008-09-24 21:23:47',
			'defmodes'  => 'Lorem ipsum dolor sit amet',
			'deftopic'  => 'Lorem ipsum dolor sit amet',
			'welcome'  => 'Lorem ipsum dolor sit amet',
			'description'  => 'Lorem ipsum dolor sit amet',
			'url'  => 'Lorem ipsum dolor sit amet',
			'motd'  => 'Lorem ipsum dolor sit amet',
			'banlevel'  => 1,
			'chmodelevel'  => 1,
			'bantype'  => 1,
			'limit_inc'  => 1,
			'limit_min'  => 1,
			'bantime'  => 1
			));
		$this->assertEqual($results, $expected);
	}
}
?>