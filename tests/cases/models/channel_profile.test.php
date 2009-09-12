<?php
/* ChannelProfile Test cases generated on: 2009-09-12 16:09:47 : 1252766747*/
App::import('Model', 'ChannelProfile');

class ChannelProfileTestCase extends CakeTestCase {
	var $fixtures = array('app.channel_profile', 'app.channel', 'app.access', 'app.user', 'app.user_profile', 'app.user_group', 'app.user_picture', 'app.news', 'app.news_type', 'app.news_comment', 'app.quote', 'app.channels_user_profile', 'app.object_status');

	function startTest() {
		$this->ChannelProfile =& ClassRegistry::init('ChannelProfile');
	}

	function endTest() {
		unset($this->ChannelProfile);
		ClassRegistry::flush();
	}

}
?>