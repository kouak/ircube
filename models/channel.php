<?php
class Channel extends AppModel {

	var $name = 'Channel';
	var $actsAs = array('Containable');
	var $displayField = 'channel';
	
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
			),
			'ObjectStatus' => array('foreignKey' => 'object_id',
									'conditions' => DATACOND_CHAN,
			),
	);
	
	var $hasOne = array(
		'ChannelProfile' => array('className' => 'ChannelProfile',
								'foreignKey' => 'channel_id',
		),
	);
	
	var $hasAndBelongsToMany = array(
		'UserProfile' => array(
			'joinTable' => 'channels_user_profiles',
		),
	);
	
	function cleanChannelName($channel) {
		return cleanChannelName($channel);
	}
	
	/* returns array id,channel */
	function autoComplete($string) {
		$channel = '#' . $this->cleanChannelName($string);
		$this->contain(false);
		$channels = $this->find('all', array(
			'conditions' => array('Channel.channel LIKE'=>$channel.'%'),
			'fields' => array('channel', 'id'),
			'order' => array('Channel.channel ASC'),
			)
		);
		return $channels;
	}
	
	/* Overload find to remove secret channels */
	
	function find($type = 'first', $options = array()) {
		if(isset($options['hideSecret']) && $options['hideSecret'] == true) {
			$options['conditions'] = am($options['conditions'], array("LOCATE('s', SUBSTRING_INDEX(Channel.defmodes, ' ', 1))" => 0));
		}
		unset($options['hideSecret']);
		return parent::find($type, $options);
	}

}
?>