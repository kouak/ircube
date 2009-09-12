<?php
/* Quote Test cases generated on: 2009-09-12 16:09:04 : 1252766704*/
App::import('Model', 'Quote');

class QuoteTestCase extends CakeTestCase {
	var $fixtures = array('app.quote', 'app.user_profile', 'app.user', 'app.object_status', 'app.channel', 'app.channel_profile', 'app.access', 'app.channels_user_profile', 'app.user_group', 'app.user_picture', 'app.news', 'app.news_type', 'app.news_comment');

	function startTest() {
		$this->Quote =& ClassRegistry::init('Quote');
	}

	function endTest() {
		unset($this->Quote);
		ClassRegistry::flush();
	}

}
?>