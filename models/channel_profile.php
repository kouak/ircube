<?php
class ChannelProfile extends AppModel {
	var $name = 'ChannelProfile';
	var $actsAs = array('Containable');
	
	var $belongsTo = array(
		'Channel' => array('className' => 'Channel',
						'foreignKey' => 'channel_id',
						'conditions' => '',
						'fields' => '',
						'order' => ''
						),
		);
}
?>