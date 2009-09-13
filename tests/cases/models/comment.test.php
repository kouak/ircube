<?php
/* Comment Test cases generated on: 2009-09-13 15:09:58 : 1252848238*/
App::import('Model', 'Comment');

class CommentTestCase extends CakeTestCase {
	var $fixtures = array('app.comment', 'app.user_profile', 'app.user', 'app.object_status', 'app.channel', 'app.channel_profile', 'app.access', 'app.channels_user_profile', 'app.user_group', 'app.user_picture', 'app.news', 'app.news_type', 'app.news_comment', 'app.quote');

	function startTest() {
		$this->Comment =& ClassRegistry::init('Comment');
	}

	function endTest() {
		unset($this->Comment);
		ClassRegistry::flush();
	}

}
?>