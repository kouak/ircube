<?php
class UserPicturesController extends AppController {
	var $name = 'UserPictures';
	var $helpers = array('Cropimage', 'Gravatar');
	var $components = array('SwfUpload');
	var $uses = array('UserPicture', 'UserProfile');
	
	function beforeFilter() {
        
		if ($this->action == 'upload') {
			$this->log($this->params);
			if(isset($this->params['url']['PHPSESSID'])) {
				$this->Session->id($this->params['url']['PHPSESSID']);
	            $this->Session->start();
			}
			elseif(isset($this->params['form']['PHPSESSID'])) {
				$this->Session->id($this->params['form']['PHPSESSID']);
	            $this->Session->start();
			}

        }
        
        parent::beforeFilter();
        
    }
	
	function upload() {
		if (isset($this->params['form']['Filedata'])) { 
            // upload the file 
            // use these to configure the upload path, web path, and overwrite settings if necessary 
            $this->SwfUpload->uploadpath = 'img' . DS . 'upload' . DS; 
            $this->SwfUpload->webpath = DS . 'img' . DS . 'upload' . DS;
            // $this->SwfUpload->overwrite = true;  //by default, SwfUploadComponent does NOT overwrite files 
            // 
			Configure::write('debug', 0);
            if ($this->SwfUpload->upload(array('img'))) { 
                // save the file to the db, or do whatever you want to do with the data 
                $this->params['form']['Filedata']['name'] = $this->SwfUpload->filename; 
                $this->params['form']['Filedata']['path'] = $this->SwfUpload->webpath; 
                $this->params['form']['Filedata']['fspath'] = $this->SwfUpload->uploadpath . $this->SwfUpload->filename; 
				$this->params['form']['Filedata']['type'] = $this->SwfUpload->mimetype;
                $this->data['UserPicture'] = $this->params['form']['Filedata'];
				
				if(!($filename = $this->UserPicture->resizeAndThumb($this->params['form']['Filedata']['fspath']))) {
					$this->set('ajaxMessage', 'ERROR:' . reset($this->UserPicture->getPhpThumbErrors()));
					return $this->render(null, 'ajax', '/ajaxempty');
				}
				$this->data['UserPicture']['filename'] = basename($filename);
				$this->data['UserPicture']['user_profile_id'] = $this->Auth->user('id') ? $this->Auth->user('id') : 0;
				
				
                if (!($UserPicture = $this->UserPicture->save($this->data))){ 
                    $this->set('ajaxMessage', 'ERROR:Database save failed');
                } else {
					$this->log($UserPicture['UserPicture']);
                    $this->set('ajaxMessage', 'FILENAME:' . 'thmb/' . $UserPicture['UserPicture']['filename'] . ';'.$this->UserPicture->getLastInsertID()); 
                } 
            } else {
                $this->set('ajaxMessage', 'ERROR:' . $this->SwfUpload->errorMessage); 
            }

        }
		$this->render(null, 'ajax', '/ajaxempty');
	}
	
	function edit() {
		$this->UserProfile->contain('Picture');
		$userProfile = $this->UserProfile->findById($this->Auth->user('id'));
		if(empty($userProfile)) {
			$this->redirect('/'); /* Should never happen (Acl magic !) */
		}
		
		$this->set($userProfile);
		
	}
	
	function delete() {
		if($this->RequestHandler->isAjax()) {
			Configure::write('debug', 0);
			if(isset($this->params['form']['id']) && is_numeric($id = $this->params['form']['id'])) {
				$this->UserPicture->id = $id;
				$this->UserPicture->read();
				if($this->Auth->user('id') == $this->UserPicture->data['UserPicture']['user_profile_id']) {
					$this->UserPicture->delete();
				}
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
			$this->redirect('/');
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
				$this->redirect(array('controller' => 'user_profiles', 'action' => 'view', 'username' => $this->Auth->user('username')));
			}
		}
		
		$this->set('UserPicture', $UserPicture);
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
	
	function avatar_step3() {
		$bla = $this->JqImgcrop->cropImage(150, $this->data['UserPicture']['x1'], $this->data['UserPicture']['y1'], $this->data['UserPicture']['x2'], $this->data['UserPicture']['y2'], $this->data['UserPicture']['w'], $this->data['UserPicture']['h'], $this->data['UserPicture']['imagePath'], $this->data['UserPicture']['imagePath']);
		debug($bla);
		
	}
	
}
?>