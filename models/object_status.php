<?php
class ObjectStatus extends AppModel {

	var $name = 'ObjectStatus';
	var $useTable = 'datas';
	
	var $actsAs = array('Containable',
						'Flaggable' => array(
								'flags' => array(
								   'DATA_RAISON_MANDATORY',
								   'DATA_FREE_ON_DEL',
								   'DATA_T_SUSPEND_CHAN',
								   'DATA_T_SUSPEND_USER',
								   'DATA_T_NOPURGE',
								   'DATA_T_CANTREGCHAN',
								),
							),
						);
	
	var $belongsTo = array(
			'Channel' => array('className' => 'Channel',
								'foreignKey' => 'object_id',
								'conditions' => DATACOND_CHAN,
			),
			'User' => array('className' => 'User',
								'foreignKey' => 'object_id',
								'conditions' => DATACOND_USER,
			)
	);
}
?>