<?php
if(!defined('DATACOND_USER'))
	define('DATACOND_USER', "Data.flag & (0x8|0x10|0x20)");
	
class User extends AppModel {

	var $name = 'User';
	
	
	var $validate = array(
		'username' => array('alphanumeric'),
		'password' => array('alphanumeric'),
		'level' => array('numeric'),
		'flag' => array('numeric'),
		'mail' => array('email'),
		'lang' => array('alphanumeric')
	);
	
	var $actsAs = array('Containable',
						'Flaggable' => array(
								'flags' => array(
									array('name' => 'PKILL','hidden' => false, 'explicit' => 'Protection(Kill)'),
									array('name' => 'PNICK','hidden' => false, 'explicit' => 'Protection(ChNick)'),
									array('name' => 'SUSPEND','hidden' => false, 'explicit' => 'Suspendu'),
									array('name' => 'NOPURGE', 'hidden' => false, 'explicit' => 'NoPurge'),
									array('name' => 'WANTX','hidden' => false, 'explicit' => 'AutoHide'),
									array('name' => 'OUBLI','hidden' => false, 'explicit' => 'Oubli'),
									array('name' => 'FIRST','hidden' => false, 'explicit' => 'Registering'),
									array('name' => 'NOMEMO','hidden' => false, 'explicit' => 'NoMemo'),
									array('name' => 'PREJECT','hidden' => false, 'explicit' => 'Acces(Rejet)'),
									array('name' => 'POKACCESS','hidden' => false, 'explicit' => 'Access(Ask)'),
									array('name' => 'PACCEPT','hidden' => false, 'explicit' => 'Access(Accepte)'),
									array('name' => 'ALREADYCHANGE','hidden' => false, 'explicit' => 'UserChanged'),
									array('name' => 'ADMBUSY','hidden' => true),
									array('name' => 'MD5PASS','hidden' => true),
									array('name' => 'HASVOTE','hidden' => true),
									array('name' => 'NOVOTE','hidden' => false, 'explicit' => 'NoVote'),
									array('name' => 'PMREPLY','hidden' => false, 'explicit' => 'ReplyMsg'),
									array('name' => 'CANTREGCHAN','hidden' => false, 'explicit' => 'CantRegChan'),
									array('name' => 'TRACKED','hidden' => true),
								),
							),
						'ChildCount',
						);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
			'Access' => array('className' => 'Access',
								'foreignKey' => 'user_id',
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
			'Memo' => array('className' => 'Memo',
								'foreignKey' => 'user_id',
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
			'Data' => array('className' => 'Data',
								'foreignKey' => 'object_id',
								'dependent' => false,
								'conditions' => DATACOND_USER,
			),
	);
	
	var $hasOne = array(
		'UserProfile' => array('className' => 'UserProfile',
								'foreignKey' => 'user_id',
		),
	);
	

	function isSuspended($data)
	{
		return $this->hasOneOfFlags($data, 'SUSPEND');
	}

}
?>