<?php
class UserProfile extends AppModel {
	var $name = 'UserProfile';
	var $actsAs = array('Containable', 'Acl' => 'requester');
	
	var $belongsTo = array(
			'User' => array('className' => 'User',
								'foreignKey' => 'user_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			),
			'UserGroup' => array('className' => 'UserGroup',
							'foreignKey' => 'user_group_id',
							'conditions' => '',
							'fields' => '',
							'order' => '',
							'counterCache' => '',
			),
			'Avatar' => array('className' => 'UserPicture',
							'foreignKey' => 'avatar_id',
							'conditions' => array('Avatar.is_avatar' => true)
			),
		);
	
	var $hasMany = array(
			'News' => array('className' => 'News',
							'foreignKey' => 'user_profile_id'
			),
			'Picture' => array('className' => 'UserPicture',
							'foreignKey' => 'user_profile_id',
							'conditions' => array('Picture.is_avatar' => false)
			),
		);
	
	var $validate = array( 
			'url' => array(
				'rule' => 'url',
				'message' => 'Lien non valide',
				'allowEmpty' => true,
			),
			'birthday' => array(
				'rule' => 'date',
				'message' => 'Date non valide'
			),
			'sex' => array(
				'rule' => array('multiple', array('in' => array('f', 'm', 'u'))),
				'message' => 'Sexe non valide'
			),
		);
	
	/* ACL */	
		
	function parentNode()
	{
		return null;
	}

	function bindNode($object)
	{
		return array(
			'model' => 'UserGroup',
			'foreign_key' => $object['UserProfile']['user_group_id']
			);
	}
		
	
	function beforeFilter() {
		$this->Auth->allow('login', 'logout');
		parent::beforeFilter();
	}
		
	/* Takes and id or array of ids as argument
	 * Sync Profiles with matching Users
	 */	
	function syncProfile($ids = array()) {
		if(is_numeric($ids)) {
			$ids = array($ids);
		}
		$synched = 0;
		
		foreach($ids as $ProfileId) {
			$this->contain('User');
			$profile = $this->findById($ProfileId); /* Lookup matching profile */
			
			if(!is_numeric($profile['User']['id']) && $profile['UserProfile']['active'] == 1) { /* User not found with active profile */
				$profile['UserProfile']['user_id'] = 0;
				$profile['UserProfile']['active'] = 0;
				$profile['UserProfile']['synched'] = date('Y-m-d H:i:s');
				$this->save($profile);
				$synched++;
				continue;
			}
			$data = array();
			if($profile['User']['username'] != $profile['UserProfile']['username']) {
				$data['username'] = $profile['User']['username']; /* and synch them */
			}
			if($profile['User']['password'] != $profile['UserProfile']['password']) {
				$data['password'] = $profile['User']['password'];
			}
			if($profile['User']['mail'] != $profile['UserProfile']['mail']) {
				$data['mail'] = $profile['User']['mail'];
			}
			if(!empty($data)) {
				$data['synched'] = date('Y-m-d H:i:s');
				$this->UserProfile->id = $User['UserProfile']['id'];
				if($this->UserProfile->save(array('UserProfile' => $data), false) == true) {
					$synched++;
				}
			}
		}
		return $synched;
	}
	
	/*
	 * Relink a profile with a given User
	 *
	 */
	
	function relinkProfile($UserProfile, $User) {
		if(!is_numeric($UserProfile['id'])) {
			return false; /* We don't want to create a new profile */
		}
		if(empty($User)) {
			return false;
		}
		$this->UserProfile->id = $UserProfile['id'];
		$UserProfile['username'] = $User['username'];
		$UserProfile['password'] = $User['password'];
		$UserProfile['mail'] = $User['mail'];
		$UserProfile['user_id'] = $User['id'];
		$UserProfile['active'] = 1;
		$UserProfile['synched'] = date('Y-m-d H:i:s');
		return $this->save(array('UserProfile' => $UserProfile), false);
	}
	
	function createProfile($UserProfile, $User) {
		if(empty($User) || !is_numeric($User['id']) || !isset($User['username']) || !isset($User['password']) || !isset($User['mail'])) {
			return false;
		}
		
		$UserProfile['username'] = $User['username'];
		$UserProfile['password'] = $User['password'];
		$UserProfile['mail'] = $User['mail'];
		$UserProfile['user_id'] = $User['id'];
		$UserProfile['active'] = 1;
		$UserProfile['synched'] = date('Y-m-d H:i:s');
		
		$this->create();
		debug($UserProfile);
		return $this->save(array('UserProfile' => $UserProfile));
	}
	
	/* Auth component hook */
	function hashPasswords($data) {
		if (is_array($data) && isset($data[$this->name]) && isset($data[$this->name]['password'])) {
		    $data[$this->name]['password'] = $this->hashPassword($data[$this->name]['password']);
		}
		return $data;
	}
	
	function hashPassword($password) {
		$xsum = md5(substr($password,0,2).$password);
		$pass = ltrim(substr($this->__dec2hex(base_convert(substr($xsum, 0,8),16,10) + base_convert(substr($xsum, 16,8),16,10)), -8), '0');
		$pass .= ltrim(substr($this->__dec2hex(base_convert(substr($xsum, 8,8),16,10) + base_convert(substr($xsum, 24,8),16,10)), -8), '0');
	    return $pass;
	}
	
	private function __dec2hex($dec) 
	{ 
	    $sign = ''; // suppress errors 
		$h = '';
		
	    if( $dec < 0){ $sign = '-'; $dec = abs($dec); } 

	    $hex = array( 0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 
	                  6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 'a', 
	                  11 => 'b', 12 => 'c', 13 => 'd', 14 => 'e',    
	                  15 => 'f' ); 

	    while ($dec >= 1)
	    { 
	        $h = $hex[(int) fmod($dec, 16)] . $h;
	        $dec = floor($dec - fmod($dec, 16)) / 16;
	    } 
		if($h[0] == '0') {
			$h[0] = '';
		}
	    return $sign . $h; 
	}
}
?>