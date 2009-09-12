<?php
/* NewsType Fixture generated on: 2009-09-12 16:09:00 : 1252765860 */
class NewsTypeFixture extends CakeTestFixture {
	var $name = 'NewsType';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'titre' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL),
		'inurl' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL),
		'classe' => array('type'=>'string', 'type' => 'string', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);

	var $records = array(
		array(
			'id' => 1,
			'titre' => 'Site',
			'inurl' => 'site',
			'classe' => 'info'
		),
		array(
			'id' => 2,
			'titre' => 'Evènement',
			'inurl' => 'evenement',
			'classe' => 'evenement'
		),
		array(
			'id' => 3,
			'titre' => 'Staff',
			'inurl' => 'staff',
			'classe' => 'info'
		),
		array(
			'id' => 4,
			'titre' => 'Réseau',
			'inurl' => 'reseau',
			'classe' => 'reseau'
		),
	);
}
?>