<?php
class AccessesController extends AppController {

	var $name = 'Accesses';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Access->recursive = 0;
		$this->set('accesses', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Access.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('access', $this->Access->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Access->create();
			if ($this->Access->save($this->data)) {
				$this->Session->setFlash(__('The Access has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Access could not be saved. Please, try again.', true));
			}
		}
		$channels = $this->Access->Channel->find('list');
		$users = $this->Access->User->find('list');
		$this->set(compact('channels', 'users'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Access', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Access->save($this->data)) {
				$this->Session->setFlash(__('The Access has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Access could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Access->read(null, $id);
		}
		$channels = $this->Access->Channel->find('list');
		$users = $this->Access->User->find('list');
		$this->set(compact('channels','users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Access', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Access->del($id)) {
			$this->Session->setFlash(__('Access deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->Access->recursive = 0;
		$this->set('accesses', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Access.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('access', $this->Access->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Access->create();
			if ($this->Access->save($this->data)) {
				$this->Session->setFlash(__('The Access has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Access could not be saved. Please, try again.', true));
			}
		}
		$channels = $this->Access->Channel->find('list');
		$users = $this->Access->User->find('list');
		$this->set(compact('channels', 'users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Access', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Access->save($this->data)) {
				$this->Session->setFlash(__('The Access has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Access could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Access->read(null, $id);
		}
		$channels = $this->Access->Channel->find('list');
		$users = $this->Access->User->find('list');
		$this->set(compact('channels','users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Access', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Access->del($id)) {
			$this->Session->setFlash(__('Access deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>