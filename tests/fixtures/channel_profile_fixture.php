<?php
/* ChannelProfile Fixture generated on: 2009-09-12 16:09:03 : 1252765683 */
class ChannelProfileFixture extends CakeTestFixture {
	var $name = 'ChannelProfile';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'created' => array('type'=>'datetime', 'type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'type' => 'datetime', 'null' => true, 'default' => NULL),
		'channel_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10),
		'description' => array('type'=>'binary', 'type' => 'binary', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array(
			'id' => 3,
			'created' => '2009-09-04 16:07:55',
			'modified' => '2009-09-04 16:07:55',
			'channel_id' => 126,
			'description' => ''
		),
		array(
			'id' => 4,
			'created' => '2009-09-04 16:20:33',
			'modified' => '2009-09-04 16:20:33',
			'channel_id' => 34,
			'description' => 'blablablali'
		),
		array(
			'id' => 5,
			'created' => '2009-09-04 16:47:50',
			'modified' => '2009-09-04 16:47:50',
			'channel_id' => 2,
			'description' => NULL
		),
	);
}
?>