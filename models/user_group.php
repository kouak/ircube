<?php
class UserGroup extends AppModel {
	var $name = 'UserGroup';
	var $actsAs = array('Acl' => 'requester');


	var $hasMany = array(
			'UserProfile' => array('className' => 'User',
								'foreignKey' => 'user_group_id',
								'conditions' => '',
								'fields' => '',
								'order' => '',
			)
		);
	
	
	function parentNode(){
		
		if (!$this->id) {
			return null;
		}

		$data = $this->read();

		if (!$data['UserGroup']['parent_id']){
			return null;
		} else {
			return $data['UserGroup']['parent_id'];
		}
	}

}
?>