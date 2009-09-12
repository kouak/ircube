<?php
/* User Test cases generated on: 2009-09-12 16:09:56 : 1252765136*/
App::import('Model', 'User');

class UserTestCase extends CakeTestCase {
	var $fixtures = array('app.user', 'app.user_profile', 'app.user_group', 'app.user_picture', 'app.news', 'app.news_type', 'app.news_comment', 'app.quote', 'app.channel', 'app.channel_profile', 'app.access', 'app.object_status', 'app.channels_user_profile');

	function startTest() {
		$this->User =& ClassRegistry::init('User');
	}

	function endTest() {
		unset($this->User);
		ClassRegistry::flush();
	}

	function testIsSuspended() {

	}

}
?>