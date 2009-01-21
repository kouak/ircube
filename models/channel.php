<?php
class Channel extends AppModel {

	var $name = 'Channel';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'Access' => array('className' => 'Access',
								'foreignKey' => 'channel_id',
								'dependent' => false,
								'conditions' => '',
								'fields' => '',
								'order' => '',
								'limit' => '',
								'offset' => '',
								'exclusive' => '',
								'finderQuery' => '',
								'counterQuery' => ''
			)
	);

}
?>