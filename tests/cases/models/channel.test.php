<?php
/* Channel Test cases generated on: 2009-09-12 16:09:41 : 1252766741*/
App::import('Model', 'Channel');

class ChannelTestCase extends CakeTestCase {
	var $fixtures = array('app.channel', 'app.channel_profile', 'app.access', 'app.user', 'app.user_profile', 'app.user_group', 'app.user_picture', 'app.news', 'app.news_type', 'app.news_comment', 'app.quote', 'app.channels_user_profile', 'app.data');

	function startTest() {
		$this->Channel =& ClassRegistry::init('Channel');
	}

	function endTest() {
		unset($this->Channel);
		ClassRegistry::flush();
	}

	function testCleanChannelName() {
		$expected = 'caca';
		$this->assertEqual($expected, $this->Channel->cleanChannelName('#caca'));
		$this->assertEqual($expected, $this->Channel->cleanChannelName('caca'));
		
		$this->assertEqual('#caca', $this->Channel->cleanChannelName('##caca'));

	}

	function testAutoComplete() {
		$expected = array(array('Channel' => array('channel' => '#lemondedethaanis', 'id' => 5)), array('Channel' => array('channel' => '#leplat', 'id' => 8)));
		$this->assertEqual($expected, $this->Channel->autoComplete('#le'));
	}
	
	function testFindHideSecret() {
		$this->assertEqual(array(), $this->Channel->find('all', array('conditions' => array('Channel.channel' => '#iserv'), 'hideSecret' => true)));
		$this->assertEqual(array('Channel' => array('channel' => '#iserv')), $this->Channel->find('first', array('fields' => array('channel'), 'conditions' => array('Channel.channel' => '#iserv'))));
	}

}
?>