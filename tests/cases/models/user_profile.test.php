<?php
/* UserProfile Test cases generated on: 2009-09-12 15:09:19 : 1252763959*/
App::import('Model', 'UserProfile');

class UserProfileTestCase extends CakeTestCase {
	var $fixtures = array('app.user_profile', 'app.user', 'app.data', 'app.channel', 'app.channel_profile', 'app.access', 'app.channels_user_profile', 'app.user_group', 'app.user_picture', 'app.news', 'app.news_comment', 'app.news_type', 'app.quote');

	function startTest() {
		$this->UserProfile =& ClassRegistry::init('UserProfile');
	}

	function endTest() {
		unset($this->UserProfile);
		ClassRegistry::flush();
	}


	function testFilterLetter() {
		$letters = array('#', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
		$expected = array_fill_keys($letters, false);
		$expected['a'] = $expected['c'] = $expected['l'] = $expected['k'] = true;
		
		$this->assertEqual($this->UserProfile->filterLetters(), $expected);

	}
	
	function testFindLetters() {
		$expected = array(array('UserProfile' => array('username' => 'caca')), array('UserProfile' => array('username' => 'Cinaee')));
		$this->assertEqual($expected, $this->UserProfile->find('letter', array('letter' => 'c', 'fields' => array('username'))));
		
		$expected = array(array('UserProfile' => array('username' => 'Cinaee')));
		$this->assertEqual($expected, $this->UserProfile->find('letter', array('letter' => 'c', 'conditions' => array('UserProfile.active' => 1), 'fields' => array('username'))));
		
		$expected = array('UserProfile' => array('username' => 'caca'));
		$this->assertEqual($expected, $this->UserProfile->find('letter', array('letter' => 'c', 'fields' => 'username', 'output' => 'first')));
	}

}
?>