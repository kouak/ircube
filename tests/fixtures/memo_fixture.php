<?php 
/* SVN FILE: $Id$ */
/* Memo Fixture generated on: 2008-09-24 21:09:52 : 1222283872*/

class MemoFixture extends CakeTestFixture {
	var $name = 'Memo';
	var $table = 'memos';
	var $fields = array(
			'id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
			'user_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10),
			'sender_id' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 10),
			'created' => array('type'=>'timestamp', 'null' => true, 'default' => NULL),
			'lastupdated' => array('type'=>'timestamp', 'null' => false, 'default' => '0000-00-00 00:00:00'),
			'flag' => array('type'=>'integer', 'null' => false, 'default' => NULL, 'length' => 5),
			'sender' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 60),
			'content' => array('type'=>'string', 'null' => false, 'default' => NULL, 'length' => 600),
			'indexes' => array('0' => array())
			);
	var $records = array(array(
			'id'  => 1,
			'user_id'  => 1,
			'sender_id'  => 1,
			'created'  => 1,
			'lastupdated'  => 1,
			'flag'  => 1,
			'sender'  => 'Lorem ipsum dolor sit amet',
			'content'  => 'Lorem ipsum dolor sit amet'
			));
}
?>