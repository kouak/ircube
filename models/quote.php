<?php
class Quote extends AppModel {

	var $name = 'Quote';
	
	var $actsAs = array('Containable');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
		'UserProfile' => array(
			'className' => 'UserProfile',
			'foreignKey' => 'user_profile_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);

}
?>