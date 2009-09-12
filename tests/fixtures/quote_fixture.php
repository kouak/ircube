<?php
/* Quote Fixture generated on: 2009-09-12 16:09:22 : 1252765882 */
class QuoteFixture extends CakeTestFixture {
	var $name = 'Quote';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'created' => array('type'=>'datetime', 'type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type'=>'datetime', 'type' => 'datetime', 'null' => true, 'default' => NULL),
		'author_id' => array('type'=>'integer', 'type' => 'integer', 'null' => true, 'default' => NULL, 'length' => 10, 'key' => 'index'),
		'channel' => array('type'=>'string', 'type' => 'string', 'null' => true, 'default' => NULL),
		'titre' => array('type'=>'string', 'type' => 'string', 'null' => true, 'default' => NULL),
		'texte' => array('type'=>'binary', 'type' => 'binary', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'user_profile_id' => array('column' => 'author_id', 'unique' => 0))
	);

	var $records = array(
		array(
			'id' => 1,
			'created' => '2009-08-26 18:26:23',
			'modified' => '2009-08-26 18:26:23',
			'author_id' => 1,
			'channel' => '#aide',
			'titre' => 'bla',
			'texte' => 'blablablabla'
		),
	);
}
?>