<?php 
/* SVN FILE: $Id$ */
/* ChannelsController Test cases generated on: 2008-09-24 21:09:11 : 1222284251*/
App::import('Controller', 'Channels');

class TestChannels extends ChannelsController {
	var $autoRender = false;
}

class ChannelsControllerTest extends CakeTestCase {
	var $Channels = null;

	function setUp() {
		$this->Channels = new TestChannels();
	}

	function testChannelsControllerInstance() {
		$this->assertTrue(is_a($this->Channels, 'ChannelsController'));
	}

	function tearDown() {
		unset($this->Channels);
	}
}
?>