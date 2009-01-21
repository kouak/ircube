<?php 
/* SVN FILE: $Id$ */
/* Access Fixture generated on: 2008-09-24 21:09:48 : 1222284288*/

class AccessFixture extends CakeTestFixture {
	var $name = 'Access';
	var $table = 'accesses';
	var $fields = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'flag' => array('type'=>'integer', 'null' => false, 'default' => '0', 'length' => 6),
			'created' => array('type'=>'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
			'modified' => array('type'=>'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
			'lastseen' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
			'channel_id' => array('type'=>'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
			'user_id' => array('type'=>'integer', 'null' => false, 'default' => '0'),
			'channel_name' => array('type'=>'string', 'null' => false, 'default' => NULL),
			'user_name' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 60),
			'level' => array('type'=>'integer', 'null' => false, 'default' => NULL),
			'info' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 600),
			'indexes' => array('0' => array())
			);
	var $records = array(array(
			'id'  => 1,
			'flag'  => 1,
			'created'  => '2008-09-24 21:24:48',
			'modified'  => '2008-09-24 21:24:48',
			'lastseen'  => '2008-09-24 21:24:48',
			'channel_id'  => 1,
			'user_id'  => 1,
			'channel_name'  => 'Lorem ipsum dolor sit amet',
			'user_name'  => 'Lorem ipsum dolor sit amet',
			'level'  => 1,
			'info'  => 'Lorem ipsum dolor sit amet'
			));
}
?>