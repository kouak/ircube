<?php
class UserPicture extends AppModel {
	var $name = 'UserPicture';
	
	var $actsAs = array('PhpThumb', 'Containable');

	var $belongsTo = array(
			'UserProfile' => array('className' => 'UserProfile',
								'foreignKey' => 'user_profile_id',
								'fields' => '',
								'order' => '',
			)
		);
	var $hasOne = array(
			'AvatarProfile' => array('className' => 'UserProfile',
									'foreignKey' => 'avatar_id',
									'conditions' => array('is_avatar' => true)
			),
		);
	
	function beforeDelete() {
		if($this->data['UserPicture']['is_avatar'] == true) {
			debug("blabla");
			$this->removeAvatar($this->data['UserProfile']['username']);
		}
		return true;
	}
	
	function removeAvatar($username) {
		if(is_file(($file = $this->avatarPath($username . '.png')))) {
			return unlink($file);
		}
		return false;
	}
}
?>