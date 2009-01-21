<?php
class UserPicture extends AppModel {
	var $name = 'UserPicture';
	
	var $actsAs = array('PhpThumb', 'Containable');

	var $belongsTo = array(
			'UserProfile' => array('className' => 'UserProfile',
								'foreignKey' => 'user_profile_id',
								'conditions' => array('is_avatar' => false),
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

}
?>