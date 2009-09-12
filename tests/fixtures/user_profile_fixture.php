<?php
/* UserProfile Fixture generated on: 2009-09-12 16:09:37 : 1252764037 */
class UserProfileFixture extends CakeTestFixture {
	var $name = 'UserProfile';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'created' => array('type'=>'datetime', 'type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'type' => 'datetime', 'null' => true, 'default' => NULL),
		'synched' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'url' => array('type'=>'string', 'type' => 'string', 'null' => true, 'default' => NULL, 'length' => 300),
		'user_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'unique'),
		'user_group_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '2', 'key' => 'index'),
		'avatar_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 20),
		'username' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 30),
		'password' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 16),
		'mail' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL, 'length' => 70),
		'active' => array('type'=>'boolean', 'type' => 'boolean', 'null' => false, 'default' => '1'),
		'lastseen' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'birthday' => array('type'=>'date', 'type' => 'date', 'null' => false, 'default' => '0000-00-00'),
		'sex' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => 'u', 'length' => 1),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'user_id' => array('column' => 'user_id', 'unique' => 1), 'user_group_id' => array('column' => 'user_group_id', 'unique' => 0))
	);

	var $records = array(
		array(
			'id' => 1,
			'created' => '2009-01-11 23:15:27',
			'modified' => '2009-08-31 17:02:28',
			'synched' => '2009-01-11 23:15:27',
			'url' => '',
			'user_id' => 25,
			'user_group_id' => 3,
			'avatar_id' => 0,
			'username' => 'kouak',
			'password' => 'b3f7f617d9fdc3ab',
			'mail' => 'kouak@ircube.org',
			'active' => 1,
			'lastseen' => '2009-09-12 15:57:07',
			'birthday' => '1985-09-20',
			'sex' => 'm'
		),
		array(
			'id' => 2,
			'created' => '2009-01-22 16:33:06',
			'modified' => '2009-01-22 16:33:06',
			'synched' => '2009-01-22 16:33:06',
			'url' => '',
			'user_id' => 9145,
			'user_group_id' => 2,
			'avatar_id' => 0,
			'username' => 'caca',
			'password' => 'eef96269835b650',
			'mail' => 'benjamin.beret@gmail.com',
			'active' => 0,
			'lastseen' => '2009-01-22 16:46:06',
			'birthday' => '2009-01-22',
			'sex' => 'u'
		),
		array(
			'id' => 3,
			'created' => '2009-01-22 18:48:31',
			'modified' => '2009-01-22 18:48:31',
			'synched' => '2009-01-22 18:48:31',
			'url' => '',
			'user_id' => 195,
			'user_group_id' => 2,
			'avatar_id' => 0,
			'username' => 'LoiC',
			'password' => 'bfdbcd766056b3eb',
			'mail' => 'loic59143@hotmail.fr',
			'active' => 1,
			'lastseen' => '2009-07-02 19:38:55',
			'birthday' => '2009-01-22',
			'sex' => 'u'
		),
		array(
			'id' => 4,
			'created' => '2009-01-22 18:52:00',
			'modified' => '2009-01-22 18:52:00',
			'synched' => '2009-01-22 18:52:00',
			'url' => '',
			'user_id' => 66,
			'user_group_id' => 2,
			'avatar_id' => 0,
			'username' => 'Ayame',
			'password' => '453c7dd632b4cfa9',
			'mail' => 'Ayame@ircube.org',
			'active' => 1,
			'lastseen' => '2009-01-26 17:34:15',
			'birthday' => '1989-01-02',
			'sex' => 'u'
		),
		array(
			'id' => 5,
			'created' => '2009-01-22 21:46:21',
			'modified' => '2009-01-22 21:46:21',
			'synched' => '2009-01-22 21:46:21',
			'url' => '',
			'user_id' => 213,
			'user_group_id' => 2,
			'avatar_id' => 0,
			'username' => 'Cinaee',
			'password' => 'cff4e4e771ec9b2',
			'mail' => 'cinaee@gmail.com',
			'active' => 1,
			'lastseen' => '2009-06-19 17:44:09',
			'birthday' => '2008-12-18',
			'sex' => 'u'
		),
	);
}
?>