<?php
/* UserGroup Fixture generated on: 2009-09-12 16:09:52 : 1252765792 */
class UserGroupFixture extends CakeTestFixture {
	var $name = 'UserGroup';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'title' => array('type'=>'string', 'type' => 'string', 'null' => true, 'default' => NULL),
		'parent_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0'),
		'created' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'modified' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array(
			'id' => 1,
			'title' => 'Guest',
			'parent_id' => 0,
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00'
		),
		array(
			'id' => 2,
			'title' => 'Membre',
			'parent_id' => 1,
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00'
		),
		array(
			'id' => 3,
			'title' => 'Modérateur',
			'parent_id' => 2,
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00'
		),
		array(
			'id' => 4,
			'title' => 'Administrateur',
			'parent_id' => 3,
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00'
		),
	);
}
?>