<?php
/* UserPicture Fixture generated on: 2009-09-12 16:09:18 : 1252765818 */
class UserPictureFixture extends CakeTestFixture {
	var $name = 'UserPicture';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'user_profile_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'key' => 'index'),
		'created' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'modified' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'filename' => array('type'=>'string', 'type' => 'string', 'null' => true, 'default' => NULL),
		'type' => array('type'=>'string', 'type' => 'string', 'null' => true, 'default' => NULL),
		'is_avatar' => array('type'=>'boolean', 'type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'user_profile_id' => array('column' => 'user_profile_id', 'unique' => 0))
	);

	var $records = array(
		array(
			'id' => 79,
			'user_profile_id' => 1,
			'created' => '2009-08-10 00:16:57',
			'modified' => '2009-08-10 00:16:57',
			'filename' => '7a339249653a2626eb6fb383fc3fc386.jpg',
			'type' => 'image/jpeg',
			'is_avatar' => 0
		),
	);
}
?>