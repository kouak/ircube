<?php
class ChannelsController extends AppController {

	var $name = 'Channels';
	var $helpers = array('Html', 'Form');


	/* AJAX callback for autocompletion */
	function autoComplete() {
		Configure::write('debug', 0);
		$this->layout = 'ajax';
		$channels = $this->Channel->autoComplete($this->params['url']['query']);
		$this->set('channels', $channels);
		$this->render('ajax/autocomplete');
	}
	
	function index() {
		$this->Channel->recursive = 0;
		$this->set('channels', $this->paginate('Channel'));
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
}
?>