<?php
class Memo extends AppModel {

	var $name = 'Memo';
	var $validate = array(
		'flag' => array('required' => true),
		'sender' => array('alphanumeric'),
		'content' => array('alphanumeric')
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	/*
	var $belongsTo = array(
			'User' => array('className' => 'User',
								'foreignKey' => 'user_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);
	*/
}
?>