<?php 
/* SVN FILE: $Id$ */
/* Access Fixture generated on: 2009-08-31 17:08:02 : 1251732842*/

class AccessFixture extends CakeTestFixture {
	var $name = 'Access';
	var $table = 'accesses';
	var $fields = array(
		'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'flag' => array('type'=>'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'modified' => array('type'=>'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'lastseen' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'channel_id' => array('type'=>'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'user_id' => array('type'=>'integer', 'null' => false, 'default' => '0'),
		'channel_name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'user_name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'level' => array('type'=>'integer', 'null' => false, 'default' => NULL),
		'info' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 200),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'chan_id' => array('column' => 'channel_id', 'unique' => 0))
	);
	var $records = array(array(
		'id'  => 1,
		'flag'  => 1,
		'modified'  => '2009-08-31 17:34:02',
		'lastseen'  => '2009-08-31 17:34:02',
		'channel_id'  => 1,
		'user_id'  => 1,
		'channel_name'  => 'Lorem ipsum dolor sit amet',
		'user_name'  => 'Lorem ipsum dolor sit amet',
		'level'  => 1,
		'info'  => 'Lorem ipsum dolor sit amet'
	));
}
?>