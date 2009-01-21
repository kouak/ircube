<?php 
/* SVN FILE: $Id$ */
/* User Fixture generated on: 2008-09-24 21:09:06 : 1222283706*/

class UserFixture extends CakeTestFixture {
	var $name = 'User';
	var $table = 'users';
	var $fields = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'username' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 32),
			'password' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 16),
			'level' => array('type'=>'integer', 'null' => false, 'default' => '1', 'length' => 6),
			'flag' => array('type'=>'integer', 'null' => false, 'default' => '0', 'length' => 6),
			'lastseen' => array('type'=>'datetime', 'null' => true, 'default' => NULL),
			'modified' => array('type'=>'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
			'created' => array('type'=>'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
			'mail' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 300),
			'lang' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 60),
			'lastlogin' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 300),
			'indexes' => array('0' => array())
			);
	var $records = array(array(
			'id'  => 1,
			'username'  => 'Lorem ipsum dolor sit amet',
			'password'  => 'Lorem ipsum do',
			'level'  => 1,
			'flag'  => 1,
			'lastseen'  => '2008-09-24 21:15:06',
			'modified'  => '2008-09-24 21:15:06',
			'created'  => '2008-09-24 21:15:06',
			'mail'  => 'Lorem ipsum dolor sit amet',
			'lang'  => 'Lorem ipsum dolor sit amet',
			'lastlogin'  => 'Lorem ipsum dolor sit amet'
			));
}
?>