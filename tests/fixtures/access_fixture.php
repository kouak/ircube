<?php
/* Access Fixture generated on: 2009-09-12 16:09:35 : 1252765715 */
class AccessFixture extends CakeTestFixture {
	var $name = 'Access';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'flag' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'modified' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'lastseen' => array('type'=>'timestamp', 'type' => 'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'channel_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'user_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0'),
		'channel_name' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'user_name' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'level' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL),
		'info' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'chan_id' => array('column' => 'channel_id', 'unique' => 0))
	);

	var $records = array(
		array(
			'id' => 1,
			'flag' => 5,
			'modified' => '0000-00-00 00:00:00',
			'lastseen' => '2006-01-24 00:05:01',
			'channel_id' => 113,
			'user_id' => 373,
			'channel_name' => '',
			'user_name' => '',
			'level' => 500,
			'info' => ''
		),
	);
}
?>