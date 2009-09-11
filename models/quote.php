<?php
class Quote extends AppModel {

	var $name = 'Quote';
	
	var $actsAs = array('Containable');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'Author' => array(
			'className' => 'UserProfile',
			'foreignKey' => 'author_id',
		),
	);

}
?>