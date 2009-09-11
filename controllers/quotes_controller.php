<?php
class QuotesController extends AppController {

	var $name = 'Quotes';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Quote->recursive = 0;
		$this->set('quotes', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Quote.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Quote->contain(array('Author' => array('fields' => array('username'))));
		$this->set('quote', $this->Quote->read(null, $id));
	}

	function add() {
		if(!is_numeric($this->Auth->user('id'))) {
			$this->Auth->deny(); /* Only authed users can post quotes */
			return;
		}
		if (!empty($this->data)) {
			$this->Quote->create();
			$this->data['Quote']['user_profile_id'] = $this->Auth->user('id');
			if ($this->Quote->save($this->data)) {
				$this->Session->setFlash(__('The Quote has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Quote could not be saved. Please, try again.', true));
			}
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Quote', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Quote->del($id)) {
			$this->Session->setFlash(__('Quote deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->Quote->recursive = 0;
		$this->set('quotes', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Quote.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('quote', $this->Quote->read(null, $id));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Quote', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Quote->save($this->data)) {
				$this->Session->setFlash(__('The Quote has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Quote could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Quote->read(null, $id);
		}
		$userProfiles = $this->Quote->UserProfile->find('list');
		$channelProfiles = $this->Quote->ChannelProfile->find('list');
		$this->set(compact('userProfiles','channelProfiles'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Quote', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Quote->del($id)) {
			$this->Session->setFlash(__('Quote deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>