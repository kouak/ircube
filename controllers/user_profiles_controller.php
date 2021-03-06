<?php
class UserProfilesController extends AppController {

	var $name = 'UserProfiles';
	var $uses = array('UserProfile', 'User');
	var $components = array('Security');
	var $helpers = array('Cropimage', 'Gravatar', 'Paginator', 'Js' => array('jquery'));
	
	function beforeFilter() {
		$this->Auth->allow('login', 'logout', 'autoComplete');
		$this->placename = 'communauté';
		parent::beforeFilter();
	}
	
	/* AJAX callback for autocompletion */
	function autoComplete() {
		Configure::write('debug', 0);
		$this->layout = 'ajax';
		$this->UserProfile->recursive = -1;
		$user_profiles = $this->UserProfile->find('all', array(
		 'conditions'=>array('UserProfile.username LIKE'=>$this->params['url']['query'].'%'),
		 'fields'=>array('username', 'id')));
		$this->set('user_profiles', $user_profiles);
	}
		
	
	function resynch_profile() {
		if($this->Auth->user()) {
			$this->Session->setFlash(__('Vous disposez déja d\'un profil.', true), 'messages/failure');
			$this->redirect($this->referer());
		}
		/* We need data from SCoderZ account and from former UserProfile */
		if(!empty($this->data)) {
			if(isset($this->data['User']['password'])) { /* Hash former password */
				$this->data['User']['password'] = $this->UserProfile->hashPassword($this->data['User']['password']);
			}
			$this->UserProfile->contain(array('User' => array('ObjectStatus' => array('conditions' => array('ObjectStatus.flag & 0x8')))));
			$userProfile = $this->UserProfile->findByUsername($this->data['UserProfile']['username']);
			$this->User->contain(array());
			$user = $this->User->findByUsername($this->data['User']['username']);

			if($userProfile['UserProfile']['active'] == 1) { /* This profile is already active, redirect to login */
				$this->Session->setFlash(__('Ce profil existe déja, identifiez-vous', true));
				$this->redirect($this->Auth->loginAction);
			}
			if(empty($user) || $user['User']['password'] != $this->data['User']['password'] || $this->User->isSuspended($user)) { /* SCoderZ account not found or suspended */
				$this->Session->setFlash(__('Erreur de login pour le compte Z.', true), 'default', array(), 'auth');
				return;
			}
			if(empty($userProfile)) { /* Profile not found */
				$this->Session->setFlash(__('Ce profil n\'existe pas.',true), 'default', array(), 'auth');
				return;
			}
			if($userProfile['UserProfile']['password'] != $this->data['UserProfile']['password']) {
				$this->Session->setFlash(__('Erreur de login pour le profil.', true), 'default', array(), 'auth');
				return;
			}
			if($this->UserProfile->relinkProfile($userProfile['UserProfile'], $user['User'])) {
				$this->Auth->identify($userProfile);
				$this->flash(__('Votre profil a été récupéré, vous êtes maintenant identifié', true), '/');
			}
			else {
				$this->Session->setFlash(__('Une erreur est survenue. Les administrateurs ont été avertis.', true), 'default', array(), 'auth');
			}
		}
	}
	
	
	
	function create_profile() {
		if($this->Auth->user()) {
			$this->Session->setFlash(__('Vous disposez déja d\'un profil.', true), 'messages/failure');
			$this->redirect($this->referer());
		}
		if(!empty($this->data)) {
			
			$this->User->data = $this->data;
			if($this->User->validates() !== true) {
				/* Few basic checks before SQL finds */
				return;
			}
			$this->User->create(null); /* Clear User->data */
			
			if(isset($this->data['User']['password'])) { /* Hash former password */
				$this->data['User']['password'] = $this->UserProfile->hashPassword($this->data['User']['password']);
			}
			
			$this->UserProfile->contain(array('User' => array('ObjectStatus' => array('conditions' => array('ObjectStatus.flag & 0x8'))))); /* Find relevant userProfile */
			$userProfile = $this->UserProfile->findByUsername($this->data['User']['username']);
			

			$this->User->contain(array('UserProfile', 'ObjectStatus' => array('conditions' => array('ObjectStatus.flag & 0x8'))));
			$user = $this->User->findByUsername($this->data['User']['username']);
			if(empty($user) || $user['User']['password'] != $this->data['User']['password'] || $this->User->isSuspended($user)) {
				$this->User->invalidate('password', __('Mot de passe invalide', true)); /* Let the user know that password is invalid */
				return;
			}
			
			if(!empty($userProfile)) {
				if($userProfile['UserProfile']['active'] == 1) {
					$this->flash(__('Ce profil existe déja avec cet username. Veuillez vous identifier.', true), array('action' => 'login'));
					return;
				}
				else {
					$this->flash(__('Un profil archivé existe déja avec cet username. Utilisez la procédure de récupération.', true), array('action' => 'resynch_profile'));
					return;
				}
			}
			
			//debug($this->data);
			
			if($this->UserProfile->createProfile($this->data['UserProfile'], $user['User'])) {
				$userProfile = $this->UserProfile->findById($this->UserProfile->id);
				$this->Auth->login($userProfile);
				$this->flash(__('Votre profil a été créé. Vous avez été automatiquement identifié.', true), array('controller' => 'user_profiles', 'action' => 'dashboard'));
			}
		}
	}
	
	function index($filter = null) { /* Trombinoscope */
		$this->placename = "trombinoscope";
		
		$this->UserProfile->contain(array());
		$userProfiles = $this->UserProfile->find('letter', array('letter' => $filter, 'output' => 'list', 'fields' => array('username'), 'conditions' => array('UserProfile.active' => 1)));
		
		$this->set('userProfiles', $userProfiles);
		
		
		$filterLetters = $this->UserProfile->filterLetters(array('conditions' => array('UserProfile.active' => 1))); /* Retrieve menu letters */
		
		if(isset($filter) && isset($filterLetters[$filter])) {
			$filterLetters[$filter] = 'active'; /* Find active */
		}
		
		$this->set('filterLetters', $filterLetters);
	}
	
	
	function dashboard() {
		/* Should never happen thanks to Acl */
		if(!$this->Auth->user('id')) {
			$this->redirect('/');
		}
	}
	
	function view($username=null) {
		if($username == null) {
			$this->redirect(array('action'=>'index'), 301);
		}
		$this->UserProfile->contain(
			array(
				'User' => array('fields' => 'created'),
				'Avatar',
				'Channel' => array('fields' => array('id', 'channel')),
				//'Comment' => array('Author' => array('fields' => array('username', 'active', 'user_id')))
				)
		);
		$userProfile = $this->UserProfile->find('first', array('conditions' => array('UserProfile.active' => 1, 'UserProfile.username' => $username)));
		if(empty($userProfile)) {
			$this->Session->setFlash(__('Cet utilisateur n\'existe pas', true), 'messages/failure');
			$this->redirect(array('action' => 'index'), 303);
		}
		if($this->Auth->user('id') == $userProfile['UserProfile']['id']) {
			$this->set('canEdit', true);
		}
		$this->set('userProfiles', $userProfile);
	}
	
	function login() {
		if(is_numeric($this->Auth->user('id'))) {
			/* User already logged in */
			$this->redirect($this->Auth->redirect());
			return;
		}
		if(!empty($this->data)) { /* Login submitted and user not logged in => try to redirect him */
			$this->UserProfile->contain(array('User' => array('ObjectStatus' => array('conditions' => array('ObjectStatus.flag & 0x8')))));
			$userProfile = $this->UserProfile->findByUsername($this->data['UserProfile']['username']);
			if(empty($userProfile)) { /* No profile yet */
				$this->User->contain(array());
				$user = $this->User->findByUsername($this->data['UserProfile']['username']);
				if(!empty($user)) {
					$this->Session->setFlash(__('Un compte Z a été trouvé avec l\'username ', true) . $this->data['UserProfile']['username'] . __('. Creez-un profil.', true), 'default', array(), 'auth');
					$this->set('createprofile', 1);
				}
				return;
			}
			if($userProfile['UserProfile']['active'] == 0) {
				/* Profile found, but no user associated => archived profile */
				$this->Session->setFlash(__('Un profil a été trouvé avec l\'username ', true) . $this->data['UserProfile']['username'] . __(' mais il a été archivé', true), 'default', array(), 'auth');
				$this->set('resynchprofile', 1);
				return; /* Display auth error */
			}
			
			return;
		}
	}
	
	function editprofile() {
		$id = $this->Auth->user('id');
		if($id > 0) {
			if (!empty($this->data)) {
				$this->data['UserProfile']['id'] = $id;
				$blackList = array('username', 'password', 'mail', 'active', 'synched', 'user_id', 'user_group_id', 'avatar_id', 'lastseen');
				if ($this->UserProfile->save($this->data, array('fieldlist' => array_diff(array_keys($this->UserProfile->schema()), $blackList)))) {
					$this->Session->setFlash(__('Votre fiche a été sauvegardée', true), 'messages/success');
					$this->redirect(array('controller' => 'user_profiles', 'action'=>'view', 'username' => $this->Auth->user('username')));
				}
				unset($this->data['UserProfile']['id']); /* Form helper fuck up */
			}
			else {
				/* Fill up edit form */
				$this->UserProfile->contain(array('Channel' => array('id', 'channel')));
				$this->data = $this->UserProfile->read(null, $id);
				unset($this->data['UserProfile']['id']); /* Form helper fuck up */
			}
		}
		else {
			$this->__authDeny();
			/* Auth error */
		}
		
	}
	
	function register() {
		if(is_numeric($this->Auth->user('id'))) {
			$this->redirect('/');
			return;
		}
		if(!empty($this->data)) { /* Data posted */
			if($this->UserProfile->set($this->data)) { /* Data validates */
				if($this->UserProfile->validates() === true) {
					$this->UserProfile->registerAfterValidate();
					
				}
			}
		}
	}

	function logout() {
		$this->Auth->logout();
		$this->redirect('/');
	}
}
?>