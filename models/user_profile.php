<?php
class UserProfile extends AppModel {
	var $name = 'UserProfile';
	var $actsAs = array('Containable', 'Acl' => 'requester');

	var $belongsTo = array(
			'User' => array(
				'className' => 'User',
				'foreignKey' => 'user_id',
				'conditions' => '',
				'fields' => '',
				'order' => ''
			),
			'UserGroup' => array(
				'className' => 'UserGroup',
				'foreignKey' => 'user_group_id',
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'counterCache' => '',
			),
			'Avatar' => array(
				'className' => 'UserPicture',
				'foreignKey' => 'avatar_id',
				'conditions' => array('Avatar.is_avatar' => true)
			),
		);

	var $hasMany = array(
			'News' => array(
				'className' => 'News',
				'foreignKey' => 'user_profile_id'
			),
			'NewsComment' => array(
				'className' => 'NewsComment',
				'foreignKey' => 'user_profile_id'
			),
			'Picture' => array(
				'className' => 'UserPicture',
				'foreignKey' => 'user_profile_id',
			),
			'Quotes' => array(
				'className' => 'Quote',
				'foreignKey' => 'author_id',
			),
		);

	var $hasAndBelongsToMany = array(
			'Channel' => array(
				'joinTable' => 'channels_user_profiles',
			),
		);

	var $validate = array(
			'username' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
					'message' => 'Veuillez saisir un pseudo',
					'last' => true,
					),
				'firstChar' => array(
					'rule' => array('custom', '@^([a-zA-Z]|_|`|\\{|\\[|]|}|\\||\\\\|\\^){1}.*@'),
					'message' => 'Votre pseudo ne peut pas commencer par un chiffre ou un tiret',
					'last' => true,
					),
				'ircNickname' => array(
					'rule' => array('custom', '@^([a-zA-Z]|_|`|\\{|\\[|]|}|\\||\\\\|\\^){1}([a-zA-Z0-9]|_|`|\\{|\\[|]|}|\\||\\\\|-|\\^){1,19}$@'),
					'message' => 'Ce pseudo est invalide',
					'last' => true,
					), /* handle wrong characters */
				'isUnique' => array(
					'rule' => 'isUnique',
					'message' => 'Un profil existe déja avec cet username, utilisez l\'interface de récupération',
					'last' => true,
					),
				'isUniqueExtended' => array(
					'rule' => 'isUsernameAvailable',
					'message' => 'Ce pseudo est déja utilisé',
					'last' => true,
					), /* Fails if user already registered, checks Z database */
				),
			'tmp-password' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
					'message' => 'Veuillez saisir un mot de passe',
					'last' => true,
					),
				'minLength' => array(
					'rule' => array('minLength', '7'),
					'message' => 'Le mot de passe doit faire au moins 7 caractères',
					'last' => true,
					),
				'equalsPassword' => array(
					'rule' => array('equalsField', 'password-confirm'),
					'message' => 'Les mots de passe doivent être identiques',
					),
				),
			'password-confirm' => array(
				'equalsPassword' => array(
					'rule' => array('equalsField', 'tmp-password'),
					'message' => 'Les mots de passe doivent être identiques',
					),
				),
			'mail' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
					'message' => 'Veuillez saisir un email'
					),
				'validEmail' => array(
					'rule' => 'email',
					'message' => 'Cet email est invalide'
					),
				'isUniqueExtended' => array(
					'rule' => 'isEmailAvailable',
					'message' => 'Cet email est déja utilisé',
					),
				'isUnique' => array(
					'rule' => 'isUnique',
					'message' => 'Un profil existe déja avec cet email, utilisez l\'interface de récupération',
					), /* Fails if user already registered, checks Z database */
				),
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

	/* 
	 * Use $options['letter'] to filter results 
	 * Use $options['output'] to set parent::find() type (default : all)
	 */

	function __findLetter($options = array()) {
		if(!isset($options['letter']) || $options['letter'] == '#') {
			$c = array(
				'OR' => array(
					'ASCII(LEFT(UserProfile.username,1)) < ' => 65,
					'AND' => array(
						'ASCII(LEFT(UserProfile.username,1)) >' => 90,
						'ASCII(LEFT(UserProfile.username,1)) <' => 97,
					),
					'ASCII(LEFT(UserProfile.username,1)) >' => 122,
				),
			); /* Handle special characters */
		} else {
			$c = array('LEFT(UserProfile.username,1)' => $options['letter'][0]);
		}
		$options['conditions'] = am(@$options['conditions'], $c);
		unset($options['letter']);
		$output = 'all';
		if(isset($options['output'])) {
			$output = $options['output'];
			unset($options['output']);
		}
		return parent::find($output, $options); 
	}
	
	
	/* 
	 * Returns array of unempty letter filters for find('letter') 
	 * e.g : array('a' => false, 'b' => true ...)
	 */
	function filterLetters($options = array()) {
		$letters = array('#', 'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');
		
		$this->contain(array());
		
		$fopt = array(
			'fields' => array('LOWER(LEFT(UserProfile.username, 1)) as initial'),
			'group' => 'LOWER(LEFT(UserProfile.username, 1))',
			'order' => 'LOWER(LEFT(UserProfile.username, 1)) ASC',
		);

		if(isset($options['conditions'])) {
			$fopt['conditions'] = $options['conditions'];
		}

		$initials = $this->find('all', $fopt);
		$initials = Set::extract('/0/initial', $initials);
		
		$specialchars = array_diff($initials, $letters);
		if(!empty($specialchars)) { /* Are there any special chars ? */
			array_unshift($initials, '#'); /* Add '#' to the front of $initials */
		}
		
		return am(array_fill_keys($letters, false), array_fill_keys($initials, true));
	}

	/* Takes an UserProfile.id or array of ids as argument
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
		$UserProfile['user_group_id'] = 2; /* Put new profiles in group members */
		$UserProfile['active'] = 1;
		$UserProfile['synched'] = date('Y-m-d H:i:s');
		$this->create();
		debug($UserProfile);
		return $this->save(array('UserProfile' => $UserProfile));
	}



	function isUsernameAvailable($data) {
		$a = $this->User->findByUsername($data['username'], array('contain' => array()));
		if(empty($a)) {
			return true;
		}
		return false;
	}

	function isEmailAvailable($data) {
		$a = $this->User->findByMail($data['mail'], array('contain' => array()));
		if(empty($a)) {
			return true;
		}
		return false;
	}

	public function equalsPassword($data, $field = '') {
		$key = key($data);
		$value = current($data);
		$value = $this->hashPassword($value);
		return $this->equalsField(array($key => $value), $field);
	}

	/* Auth component hook */
	function hashPasswords($data) {
		if (is_array($data) && isset($data[$this->name]) && isset($data[$this->name]['password'])) {
		    $data[$this->name]['password'] = $this->hashPassword($data[$this->name]['password']);
		}
		return $data;
	}

	function registerAfterValidate() {
		if(isset($this->data[$this->name]['tmp-password'])) {
			$this->data[$this->name]['password'] = $this->hashPassword($this->data[$this->name]['tmp-password']);
			unset($this->data[$this->name]['tmp-password']);
		}
		return;
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

	function W2CRegister($data) {
		/* Register an user with Z */

		if (!isset($this->data['NewUser']['id'])) {
			$query = 'REGISTER '.$this->data['NewUser']['pseudo'].' '.$this->data['NewUser']['mail'].' '.$this->data['NewUser']['password'].' '. $this->data['NewUser']['ip'] ;

			/* Envoi de la requête */
			$w2c = new web2csService();
			$w2c->connect();
			if ($w2c->query($query)) {
				$res = $w2c->get_result();
				/* On récupère l'id pour la sauvegarde dans la bdd */
				$this->data['NewUser']['id'] = $res['userid'] ;
				$w2c->disconnect();
				return true ;
			} else {
				/* Il y a eu une erreur dans la création, on stope l'enregistrement */
				switch($w2c->get_error_code()) {
					case 'USER_INUSE' : {
						$this->invalidate('pseudo','Ce pseudonyme existe déjà, veuillez en saisir un autre');
						break;
					}
					case 'USER_MAILINUSE' : {
						$this->invalidate('mail','Cette adresse email est déjà utilisée par un utilisateur');
						break;
					}
				}
				$w2c->disconnect();
				return false ;
			}
		} else {
			/* Il a un identifiant : c'est une mise à jour */
			/* A écrire (va falloir simplifier) */
		}

	}



}
?>