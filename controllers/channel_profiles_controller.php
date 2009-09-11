<?php
class ChannelProfilesController extends AppController {

	var $name = 'ChannelProfiles';
	var $uses = array('ChannelProfile', 'Channel');

	function index() {
		$this->paginate = array('contain' => array('Channel'), 'order' => 'Channel.channel');
		$this->set('channelProfiles', $this->paginate('ChannelProfile'));
	}

	function view($channel = null) {
		/* TODO : secret channels ?*/
		if (!$channel) {
			$this->redirect(array('action'=>'index'));
		}
		if($channel[0] == '#') {
			$channel = $this->Channel->cleanChannelName($channel);
			$this->redirect(array('action' => 'view', 'channel' => $channel), 301);
		}
		
		/* Set up query */
		
		/* Find quotes */
		$this->ChannelProfile->bindModel(array(
			'hasMany' => array(
				'Quote' => array(
					'foreignKey' => false,
					'conditions' => array('Quote.channel' => '#' . $channel)
				)
			)
		));
		$contain = array(
			'ChannelProfile' => array(
				'Quote',
			), /* Profile infos */
			'UserProfile' => array( /* Who likes this channel ?*/
				'fields' => array('username'), 
				'limit' => 10,
				'order' => 'RAND(NOW())',
			)
		);
		if(is_numeric($this->Auth->user('id'))) { /* Add conditions to contain */
			$contain['Access'] = array( /* Who can edit this channel */
				'conditions' => array('Access.user_id' => $this->Auth->user('user_id')),
				'fields' => array('level'),
			);
		}
		$this->Channel->contain($contain);
		$channel = $this->Channel->findByChannel('#' . $channel);
		if(empty($channel)) { 
			/* Salon non enregistré */
			$this->Session->setFlash(__('Ce salon n\'est pas enregistré', true), 'messages/failure');
			$this->redirect(array('action' => 'index'), 303);
		}
		
		if($channel['ChannelProfile']['id'] == false) {
			/* Pas de profil */
			$this->set('noprofile', true);
		}
		
		$this->set('channelProfile', $channel);
	}

	function create($channel = null) {
		if (!$channel) {
			if(!is_numeric($this->Auth->user('id'))) {
				$this->Auth->deny();
			}
			$this->Channel->Access->contain(array('Channel' => array('ChannelProfile')));
			$accesses = $this->Channel->Access->find('all', array('conditions' => array('Access.user_id' => $this->Auth->user('user_id'))));
			$a = array();
			foreach($accesses as $access) {
				if(empty($access['Channel']['ChannelProfile'])) { /* Only list channels without profile */
					$a[] = $access;
				}
			}
			$this->set('accesses', $a);
			$this->render('create-step1'); /* Display available channels based on access */
			return; 
		}
		if($channel[0] == '#') {
			$channel = $this->Channel->cleanChannelName($channel);
			$this->redirect(array('action' => 'create', 'channel' => $channel), 301); /* Url cleanup */
		}
		$this->Channel->contain(array('ChannelProfile', 'Access' => array('conditions' => array('Access.user_id' => $this->Auth->user('user_id')))));
		$c = $this->Channel->findByChannel('#' . $channel);
		/* Clean up bad requests */
		if(empty($c)) { 
			/* Salon non enregistré */
			$this->Session->setFlash(__('Ce salon n\'est pas enregistré', true), 'messages/failure');
			$this->redirect(array('action' => 'create', 'channel' => null), 303);
		}
		
		if(is_numeric($c['ChannelProfile']['id'])) {
			/* Profil déja existant */
			$this->setFlash(__('Ce salon a déja un profil', true), 'messages/failure');
			$this->redirect(array('action' => 'view', 'channel' => $channel));
		}
		/* Access check up */
		if(empty($c['Access'])) {
			$this->authDeny();
			return;
		}
		$this->set('channel', $channel);
		if (!empty($this->data)) {
			$this->ChannelProfile->create();
			$this->data['ChannelProfile']['channel_id'] = $c['Channel']['id'];
			if ($this->ChannelProfile->save($this->data)) {
				$this->Session->setFlash(__('Le profile a été sauvegardé', true), 'messages/success');
				$this->redirect(array('action'=>'view', $channel));
			} else {
				$this->Session->setFlash(__('Le profil n\'a pas été sauvegardé', true), 'messages/failure');
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid ChannelProfile', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->ChannelProfile->save($this->data)) {
				$this->Session->setFlash(__('The ChannelProfile has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The ChannelProfile could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ChannelProfile->read(null, $id);
		}
		$channels = $this->ChannelProfile->Channel->find('list');
		$this->set(compact('channels'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for ChannelProfile', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ChannelProfile->del($id)) {
			$this->Session->setFlash(__('ChannelProfile deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>