<?php
/* Data Fixture generated on: 2009-09-12 16:09:27 : 1252765467 */
class DataFixture extends CakeTestFixture {
	var $name = 'Data';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'flag' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'created' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'modified' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'expire' => array('type'=>'datetime', 'type' => 'datetime', 'null' => false, 'default' => '0000-00-00 00:00:00'),
		'sender' => array('type'=>'string', 'type' => 'string', 'null' => false, 'length' => 30),
		'object_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '0'),
		'raison' => array('type'=>'string', 'type' => 'string', 'null' => false, 'length' => 300),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array(
			'id' => 6,
			'flag' => 4,
			'created' => '2008-10-14 22:57:22',
			'modified' => '0000-00-00 00:00:00',
			'expire' => '0000-00-00 00:00:00',
			'sender' => 'OZ',
			'object_id' => 152,
			'raison' => 'si j\'veux !'
		),
		array(
			'id' => 7,
			'flag' => 4,
			'created' => '2008-10-15 01:01:11',
			'modified' => '0000-00-00 00:00:00',
			'expire' => '0000-00-00 00:00:00',
			'sender' => 'Cesar',
			'object_id' => 153,
			'raison' => 'ssssss s'
		),
		array(
			'id' => 16,
			'flag' => 8,
			'created' => '2008-10-22 00:29:55',
			'modified' => '0000-00-00 00:00:00',
			'expire' => '2008-10-24 00:29:55',
			'sender' => 'kouak',
			'object_id' => 9120,
			'raison' => 'Bla'
		),
		array(
			'id' => 17,
			'flag' => 4,
			'created' => '2008-10-24 14:51:20',
			'modified' => '0000-00-00 00:00:00',
			'expire' => '2008-10-25 14:51:20',
			'sender' => 'kouak',
			'object_id' => 2,
			'raison' => 'Test'
		),
		array(
			'id' => 21,
			'flag' => 8,
			'created' => '2008-10-29 00:05:45',
			'modified' => '0000-00-00 00:00:00',
			'expire' => '1970-01-01 01:00:00',
			'sender' => 'ZeoX',
			'object_id' => 44,
			'raison' => '-nolog'
		),
	);
}
?>