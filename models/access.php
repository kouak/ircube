<?php
class Access extends AppModel {

	var $name = 'Access';

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $belongsTo = array(
			'Channel' => array('className' => 'Channel',
								'foreignKey' => 'channel_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'User' => array('className' => 'User',
								'foreignKey' => 'user_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>