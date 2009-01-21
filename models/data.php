<?php
if(!defined('DATACOND_CHAN'))
	define('DATACOND_CHAN', "Data.flag & 0x4");
if(!defined('DATACOND_USER'))
	define('DATACOND_USER', "Data.flag & (0x8|0x10|0x20)");
class Data extends AppModel {

	var $name = 'Data';
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