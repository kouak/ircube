<?php
class MemosController extends AppController {

	var $name = 'Memos';
	var $helpers = array('Html', 'Form');

	function index() {
		$this->Memo->recursive = 0;
		$this->set('memos', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Memo.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('memo', $this->Memo->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Memo->create();
			$this->Memo->set($this->data);
			debug($this->Memo->invalidFields());
			
			if ($this->Memo->save($this->data)) {
				$this->Session->setFlash(__('The Memo has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Memo could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Memo', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Memo->save($this->data)) {
				$this->Session->setFlash(__('The Memo has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Memo could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Memo->read(null, $id);
		}
		$users = $this->Memo->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Memo', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Memo->del($id)) {
			$this->Session->setFlash(__('Memo deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}


	function admin_index() {
		$this->Memo->recursive = 0;
		$this->set('memos', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid Memo.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('memo', $this->Memo->read(null, $id));
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->Memo->create();
			if ($this->Memo->save($this->data)) {
				$this->Session->setFlash(__('The Memo has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Memo could not be saved. Please, try again.', true));
			}
		}
		$users = $this->Memo->User->find('list');
		$this->set(compact('users'));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Memo', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Memo->save($this->data)) {
				$this->Session->setFlash(__('The Memo has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Memo could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Memo->read(null, $id);
		}
		$users = $this->Memo->User->find('list');
		$this->set(compact('users'));
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Memo', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Memo->del($id)) {
			$this->Session->setFlash(__('Memo deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

}
?>