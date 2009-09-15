<?php
class UserPicturesController extends AppController {
	var $name = 'UserPictures';
	var $helpers = array('Cropimage', 'Gravatar', 'Session');
	var $components = array('YuiUpload');
	var $uses = array('UserProfile', 'Image', 'UserProfile');
	
	function beforeFilter() {
		if(isset($this->params['form'][Configure::read('Session.cookie')])) {
			$this->Session->id($this->params['form'][Configure::read('Session.cookie')]);
		}
		parent::beforeFilter();
	}
	function admin_index() {
		$this->paginate = array(
			'limit' => 30,
			'order' => array(
				'UserPicture.created' => 'desc'
				),
			'contain' =>  array(
				'UserProfile',
				),
			);
		$this->set('user_pictures', $this->paginate('UserPicture'));
	}
	
	function upload() {
		if (isset($this->params['form']['Filedata'])) { 
			$this->data['Image']['filename'] = $this->params['form']['Filedata'];	
		}
		$this->data['Image']['user_profile_id'] = $this->Auth->user('id');
		if(!($image = $this->UserProfile->Image->save(array('Image' => $this->data['Image'])))) {
			$this->log($this->UserProfile->Image->invalidFields());
			$this->set('ajaxMessage', 'ERROR:' . reset($this->UserProfile->Image->invalidFields()));
		} else {
			App::import('Helper', 'Javascript');
			$a =& new JavascriptHelper();
			/* JSon */
			$image['Image']['id'] = $this->Image->getLastInsertID();
			$this->set('ajaxMessage', 'SUCCESS:' . $a->object($image));
		}
		Configure::write('debug', 0);
		$this->render(null, 'ajax', '/ajaxempty');
		return;	 
	}
	
	function edit() {
		$this->UserProfile->contain('Image');
		$userProfile = $this->UserProfile->findById($this->Auth->user('id'));
		if(empty($userProfile)) {
			$this->redirect('/'); /* Should never happen (Acl magic !) */
		}
		
		$this->set('userProfile', $userProfile);
		
	}
	
	function delete() {
		if($this->RequestHandler->isAjax()) {
			//Configure::write('debug', 0);
			if(isset($this->params['form']['id']) && is_numeric($id = $this->params['form']['id'])) {
				$this->Image->id = $id;
				$this->Image->read();
				if($this->Auth->user('id') == $this->Image->data['Image']['user_profile_id']) {
					$this->Image->delete();
				} else {
					/* Security blackhole */
				}
				$this->set('ajaxMessage', 'success');
				$this->render(null, 'ajax', '/ajaxempty');
			}
		}
		$this->set('ajaxMessage', 'success');
		$this->render(null, 'ajax', '/ajaxempty');
	}
	
	function admin_delete() {
		if($this->RequestHandler->isAjax()) {
			Configure::write('debug', 0);
			if(isset($this->params['form']['id']) && is_numeric($id = $this->params['form']['id'])) {
				$this->UserPicture->id = $id;
				$this->UserPicture->read();
				$this->UserPicture->delete();
				$this->set('ajaxMessage', 'success');
				$this->render(null, 'ajax', '/ajaxempty');
			}
		}
	}
	
    function avatarify($id=null) {
		if($id == null) {
			$this->redirect('/');
		}
		
		/* Check if supplied image id belongs to Authed user */
		
		$this->UserPicture->contain();
		$UserPicture = $this->UserPicture->findById($id);
		
		if(empty($UserPicture)) {
			$this->redirect('/');
		}
		
		if($UserPicture['UserPicture']['user_profile_id'] != $this->Auth->user('id')) {
			$this->deny();
		}
		if (!empty($this->data)) {
			$settings = array(
				'sx' => intval($this->data['UserPicture']['x1']),
				'sy' => intval($this->data['UserPicture']['y1']),
				'sw' => intval($this->data['UserPicture']['w']),
				'sh' => intval($this->data['UserPicture']['h']),
				'output' => $this->UserPicture->avatarPath(low($this->Auth->user('username')) . '.png'),
			);
			
			if(!$this->UserPicture->createAvatar($this->UserPicture->uploadPath($UserPicture['UserPicture']['filename']), $settings)) {
				$this->Session->setFlash(__('Oops ! Quelque chose s\'est mal passé pendant la création de votre avatar !', true), 'messages/failure');
			} else {
				$this->Session->setFlash(__('Admirez votre superbe nouvel avatar !', true), 'messages/success');
				$this->UserPicture->save(array('UserPicture' => array('id' => $UserPicture['UserPicture']['id'], 'is_avatar' => true)), false, array('id', 'is_avatar'));
				$this->redirect(array('controller' => 'home', 'action' => 'index'));
			}
		}
		
		$this->set('UserPicture', $UserPicture);
	}
	
	function avatar() {
		if($this->Auth->user('id') >= 0) {
			$this->UserProfile->contain(array('Picture', 'Avatar'));
			if(empty($this->data)) {
				$this->set('userProfile', $this->UserProfile->findById($this->Auth->user('id')));
			}
		}
		else {
			$this->deny();
		}
	}
	
	function use_gravatar() {
		if($this->RequestHandler->isAjax()) {
			Configure::write('debug', 0);
			$this->set('ajaxMessage', 'success');
			if($this->Auth->user('id') > 0) {
				if($this->UserPicture->removeAvatar($this->Auth->user('username'))) {
					$this->set('ajaxMessage', 'success');
				}
			}
			$this->render(null, 'ajax', '/ajaxempty');
		}
		else {
			$this->redirect('/');
		}
	}
	
	function avatar_from_gallery() {
		$id = $this->Auth->user('id');
		if($id <= 0) {
			$this->deny();
		}
		$this->UserProfile->contain(array('Picture'));
		$bla = $this->UserProfile->findById($id);
		$this->set($bla);
	}
	
	function index() {
		$images = $this->UserPicture->find('all');
		$this->set('images', $images);
	}
	
	function gallery($id = null) {
		if($id == null) {
			$this->redirect('/');
		}
		$this->UserProfile->contain(array('Picture'));
		$bla = $this->UserProfile->findByUsername($id);
		if(empty($bla)) {
			$this->Session->setFlash(__('Cet utilisateur n\'existe pas', true), 'message/failure');
			$this->redirect('/');
		}
		$this->set($bla);
	}
	
}
?>