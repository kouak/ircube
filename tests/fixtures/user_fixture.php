<?php
/* User Fixture generated on: 2009-09-12 16:09:30 : 1252764570 */
class UserFixture extends CakeTestFixture {
	var $name = 'User';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'user_group_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0'),
		'username' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'password' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 16),
		'level' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '1', 'length' => 6),
		'flag' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'lastseen' => array('type'=>'datetime', 'type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'created' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'mail' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 70),
		'lang' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 15),
		'lastlogin' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array(
			'id' => 1,
			'user_group_id' => 0,
			'username' => 'Cesar',
			'password' => 'password',
			'level' => 4,
			'flag' => 25608,
			'lastseen' => '2009-01-15 18:41:20',
			'modified' => '2009-01-15 18:41:26',
			'created' => '2002-07-17 05:01:24',
			'mail' => 'Cesar@ircube.org',
			'lang' => 'francais',
			'lastlogin' => 'Cesar!~Cesar@127.0.0.1'
		),
		array(
			'id' => 25,
			'user_group_id' => 2,
			'username' => 'kouak',
			'password' => 'password',
			'level' => 4,
			'flag' => 25096,
			'lastseen' => '2009-01-15 15:23:43',
			'modified' => '2009-01-15 15:26:26',
			'created' => '1985-09-20 19:15:00',
			'mail' => 'kouak@ircube.org',
			'lang' => 'francais',
			'lastlogin' => 'kouak!~kouak@88.164.110.251'
		),
	);
}
?>