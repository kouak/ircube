<?php
/* ChannelsUserProfile Fixture generated on: 2009-09-12 16:09:59 : 1252765739 */
class ChannelsUserProfileFixture extends CakeTestFixture {
	var $name = 'ChannelsUserProfile';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'channel_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'user_profile_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'channel_id' => array('column' => array('channel_id', 'user_profile_id'), 'unique' => 0))
	);

	var $records = array(
		array(
			'id' => 38,
			'channel_id' => 34,
			'user_profile_id' => 1
		),
		array(
			'id' => 37,
			'channel_id' => 122,
			'user_profile_id' => 1
		),
		array(
			'id' => 36,
			'channel_id' => 101,
			'user_profile_id' => 1
		),
	);
}
?>