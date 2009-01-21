<?php
class ChannelsController extends AppController {

	var $name = 'Channels';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Channel->recursive = 0;
		$this->set('channels', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Channel.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('channel', $this->Channel->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Channel->create();
			if ($this->Channel->save($this->data)) {
				$this->Session->setFlash(__('The Channel has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Channel could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Channel', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Channel->save($this->data)) {
				$this->Session->setFlash(__('The Channel has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Channel could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Channel->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Channel', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Channel->del($id)) {
			$this->Session->setFlash(__('Channel deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->Channel->recursive = 0;
		$this->set('channels', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Channel.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('channel', $this->Channel->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Channel->create();
			if ($this->Channel->save($this->data)) {
				$this->Session->setFlash(__('The Channel has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Channel could not be saved. Please, try again.', true));
			}
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Channel', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Channel->save($this->data)) {
				$this->Session->setFlash(__('The Channel has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Channel could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Channel->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Channel', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Channel->del($id)) {
			$this->Session->setFlash(__('Channel deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>