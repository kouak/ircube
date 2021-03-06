<?php
class UserPicturesController extends AppController {
	var $name = 'UserPictures';
	var $helpers = array('Cropimage', 'Gravatar', 'Session', 'Media.Medium', 'Cache');
	var $uses = array('UserProfile', 'Media.Attachment');
	
	function beforeFilter() {
		if(isset($this->params['form'][Configure::read('Session.cookie')])) {
			$this->Session->id($this->params['form'][Configure::read('Session.cookie')]); /* Swfupload session hack */
		}
		parent::beforeFilter();
		$this->Auth->allow('avatar');
	}
	function admin_index() {
		$this->paginate = array(
			'limit' => 30,
			'order' => array(
				'Attachment.created' => 'desc'
				),
			'conditions' => array(
				'Attachment.model' => 'UserProfile',
				),
			'contain' =>  array(
				'UserProfile' => array('id', 'username'),
				),
			);
		$this->set('user_pictures', $this->paginate('Attachment'));
	}
	
	function upload() {
		Configure::write('debug', 0);
		if (isset($this->params['form']['Filedata'])) { 
			$this->data['UserProfile']['Attachment']['file'] = $this->params['form']['Filedata'];
		}
		$this->data['UserProfile']['Attachment']['foreign_key'] = $this->Auth->user('id');
		$this->data['UserProfile']['Attachment']['model'] = 'UserProfile';
		if(!($attachment = $this->UserProfile->Attachment->save(array('Attachment' => $this->data['UserProfile']['Attachment'])))) {
			$this->log($this->UserProfile->Attachment->invalidFields());
			$this->set('ajaxMessage', 'ERROR:' . reset($this->UserProfile->Attachment->invalidFields()));
		} else {
			App::import('Helper', 'Javascript');
			$a =& new JavascriptHelper();
			/* JSon */
			$attachment['Attachment']['id'] = $this->UserProfile->Attachment->getLastInsertID();
			$this->set('ajaxMessage', 'SUCCESS:' . $a->object($attachment));
		}
		
		$this->render(null, 'ajax', '/ajaxempty');
		return;	 
	}
	
	function edit() {
		$this->UserProfile->contain('Attachment', 'Avatar');
		$userProfile = $this->UserProfile->findById($this->Auth->user('id'));
		if(empty($userProfile)) {
			$this->redirect('/'); /* Should never happen (Acl magic !) */
		}
		
		$this->set('userProfile', $userProfile);
		
	}
	
	function getImageDiv($id = null) {
		if($this->RequestHandler->isAjax()) {
			Configure::write('debug', 0);
			if(is_numeric($id) || (isset($this->params['form']['id']) && is_numeric($id = $this->params['form']['id']))) {
				$this->UserProfile->Attachment->id = $id;
				$this->UserProfile->Attachment->read();
				$this->layout = 'ajax';
				$this->set('attachment', $this->UserProfile->Attachment->data);
				$this->render('ajax/singleimage');
			}
		}
	}
	
	function delete() {
		if($this->RequestHandler->isAjax()) {
			Configure::write('debug', 0);
			if(isset($this->params['form']['id']) && is_numeric($id = $this->params['form']['id'])) {
				$this->UserProfile->Attachment->id = $id;
				$this->UserProfile->Attachment->read();
				if($this->UserProfile->Attachment->data['Attachment']['model'] == 'UserProfile' && $this->Auth->user('id') == $this->UserProfile->Attachment->data['Attachment']['foreign_key']) {
					$this->UserProfile->Attachment->delete();
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
				$this->UserProfile->Attachment->id = $id;
				$this->UserProfile->Attachment->read();
				$this->UserProfile->Attachment->delete();
				$this->set('ajaxMessage', 'success');
				$this->render(null, 'ajax', '/ajaxempty');
			}
		}
	}
	
	function unavatarify() {
		if(!$this->__isLoggedIn()) {
			$this->__authDeny();
		}
		
		if($this->RequestHandler->isAjax()) {
			Configure::write('debug', 0);
		}
		$this->__clearAvatarCache($up['UserProfile']['username']);
		/* Remove current avatar */
		if(!$this->UserProfile->Avatar->updateAll(array('Avatar.group' => null), array('Avatar.model' => 'UserProfile', 'Avatar.foreign_key' => $this->Auth->user('id')))) {
			$this->set('ajaxMessage', 'ERROR:' . __('Unable to remove current avatar', true));
		} else {
			$this->set('ajaxMessage', 'success');
		}
		$this->render(null, 'ajax', '/ajaxempty');
	}
	
	function avatarify($id=null) {
		if(!$this->__isLoggedIn()) {
			$this->__authDeny();
		}
		
		if($this->RequestHandler->isAjax()) {
			Configure::write('debug', 0);
		}
		
		$message = __('Admirez votre nouvel avatar !', true);
		$error = false;
		
		
		if(is_numeric($id) || (isset($this->params['form']['id']) && is_numeric($id = $this->params['form']['id']))) {
			
			$this->UserProfile->Attachment->id = $id;
			$this->UserProfile->Attachment->read();
			$attachment = $this->UserProfile->Attachment->data;
			
			if(empty($attachment) || $attachment['Attachment']['model'] != 'UserProfile' || $attachment['Attachment']['foreign_key'] != $this->Auth->user('id')) { /* Security failure ? */
				$this->__authDeny();
			}
			
			/* Find current avatar and remove it */
			$this->UserProfile->contain('Avatar');
			$up = $this->UserProfile->findById($this->Auth->user('id'));
			/* Clear cache */
			$this->__clearAvatarCache($up['UserProfile']['username']);
			if(!empty($up['Avatar'])) {
				/* Remove current avatar */
				if(!$this->UserProfile->Avatar->updateAll(array('Avatar.group' => null), array('Avatar.model' => 'UserProfile', 'Avatar.foreign_key' => $this->Auth->user('id')))) {
					$message = __('failed to remove old avatar', true);
					$error = true;
				}
			}
			if($error === false) {
				$this->UserProfile->Avatar->id = $id;
				if(!$this->UserProfile->Avatar->saveField('group', 'avatar')) {
					$message = __('failed to save new avatar', true);
					$error = true;
				}
			}
		}

		if($this->RequestHandler->isAjax()) {
			if($error === true) {
				$this->set('ajaxMessage', 'ERROR:' . $message);
			} else {
				$this->set('ajaxMessage', 'success');
			}
			$this->render(null, 'ajax', '/ajaxempty');
			return;
		} else {
			if($error === true) {
				$this->Session->setFlash(__('Une erreur s\'est produite : ', true) . $message, 'messages/failure');
			} else {
				$this->Session->setFlash($message, 'messages/success');
			}
			$this->redirect('/');
		}
	}
	
	
	/* Utility functions */
	private function __getMediaSizes($config = null) {
		/* Import sizes from media plugin configuration */
		if($config == null) {
			$config = $this->__getMediaConfig();
		}
		return array_keys($config);
	}
	
	private function __getMediaConfig() {
		return Configure::read('Media.filter.image');
	}
	/* Clear user cache, should be in model ?*/
	private function __clearAvatarCache($username) {
		$username = low((string) $username);
		foreach($this->__getMediaSizes() as $size) {
			if(!Cache::delete(sprintf('Avatar.%s.%s', $size, $username), 'short')) {
				return false;
			}
		}
		return true;
	}
	
	/* Typical call :
		avatar/xs/username.jpg
		or avatar/username.jpg
	*/
	function avatar($size = null, $username = null) {
		
		Configure::write('debug', 0); /* Debug messages don't look good in jpeg */
		
		/* Get informations from Media plugin */
		$sizes = $this->__getMediaSizes();
		
		
		if($size == null && $username == null) {
			/* 404 error */
			$this->cakeError('error404');
		}
		if($username == null) {
			$username = $size;
			unset($size);
		}
		
		if(!isset($size) || !in_array(($size = low($size)), $sizes)) {
			/* Fallback to default size */
			$size = Configure::read('UserPictures.defaultsize'); /* Default size */
		}
		
		/* Remove file extension from username */
		if(strchr($username, '.')) {
			$username = low(implode('.', explode('.', $username, -1)));
		}
		
		/* Cache read */
		$cacheId = sprintf('Avatar.%s.%s', $size, $username);
		$avatar = Cache::read($cacheId, 'short');
		
		if(empty($avatar)) { /* If cache is empty, query database */
			$this->UserProfile->contain('Avatar');
			$UserProfile = $this->UserProfile->findByUsername($username);
			
			App::import('Helper', 'Media.Medium'); /* Import medium helper to generate full path */
			$medium = new MediumHelper();
			
			$fallback = $file = $size . DS . 'static' . DS . 'img' . DS . 'no_avatar.png';
			if(!empty($UserProfile['UserProfile']) && !empty($UserProfile['Avatar']['id'])) {
 				/* Attachment found, serve avatar */
				$file = $size . DS . $UserProfile['Avatar']['dirname'] . DS . $UserProfile['Avatar']['basename'];
			}
			
			$fullPath = $medium->file($file); /* Build full path */
			if(!is_file($fullPath)) { /* WTF ? Serve fallback anyway ... */
				$fullPath = $medium->file($fallback);
			}
			list($filename, $path) = array(basename($fullPath), dirname($fullPath) . DS);
			$avatar = array(
				'params' => array(
					'id' => $filename,
					'name' => $username,
					'download' => false,
					'extension' => 'png',
					'path' => $path,
					'cache' => false, /* Allow browser to cache it for one hour */
				),
			);
			/* Write cache */
			Cache::write($cacheId, $avatar, 'short');
		}
		/* Serve avatar */
		if(is_array($avatar['params'])) { /* Serve MediaView */
			//debug($avatar);
			$this->view = 'Media';
			$this->set($avatar['params']);
			$this->render();
		} else {
			/* Should never happen */
		}
		
		exit();
	}
	
	function avatar_from_gallery() {
		$id = $this->Auth->user('id');
		if($id <= 0) {
			$this->_authDeny();
		}
		$this->UserProfile->contain(array('Attachment', 'Avatar'));
		$bla = $this->UserProfile->findById($id);
		$this->set('userProfile', $bla);
	}
	
	function gallery($id = null) {
		if($id == null) {
			$this->redirect('/');
		}
		$this->UserProfile->contain(array('Attachment', 'Avatar'));
		$bla = $this->UserProfile->findByUsername($id);
		if(empty($bla)) {
			$this->cakeError('error404');
			return;
		}
		$this->set('userProfile', $bla);
	}
	
}
?>