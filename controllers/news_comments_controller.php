<?php
class NewsCommentsController extends AppController {

	var $name = 'NewsComments';
	var $helpers = array('Form', 'Paginator', 'Time', 'Tinymce', 'Javascript', 'Gravatar', 'ProfileHelper');
	var $components = array('RequestHandler');
	var $uses = array('News', 'NewsComment', 'NewsType');

	function admin_index() {
		$this->placename = 'lastcomments';
		if($this->RequestHandler->isAjax()) {
			$this->paginate = array(
				'limit' => 10,
				'order' => array(
					'NewsComment.created' => 'desc'
					),
				'contain' =>  array(
					'News' => array('fields' => array('id', 'permalink')),
					'Author' => array('Avatar', 'fields' => array('username', 'mail', 'active', 'user_id'))
					),
				);
			$this->set('news_comments', $this->paginate('NewsComment'));
			Configure::write('debug', 0);
			$this->render('ajax/admin_index', 'ajax');
		}
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid NewsComment.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('newsComment', $this->NewsComment->read(null, $id));
	}
	
	function add() {
		if($this->RequestHandler->isAjax()) {
			if(!empty($this->data)) {
				Configure::write('debug', 0);
				$this->data['NewsComment']['user_profile_id'] = $this->Auth->user('id') ? $this->Auth->user('id') : 0;
				/* TODO : read from configuration */
				$this->data['NewsComment']['published'] = 1;
				App::import('Sanitize'); /* Data sanitization */
				$this->data['NewsComment']['content'] = Sanitize::html($this->data['NewsComment']['content']);
				if($this->NewsComment->save($this->data, array('fieldList' => array('user_profile_id', 'content', 'news_id', 'published')))) {
					$this->NewsComment->recursive = -1;
					$this->set('comment', $this->NewsComment->read());
					$this->render('ajax/add_comment_success', 'ajax');
				}
				else {
					$this->render('ajax/add_comment_fail', 'ajax');
				}
			}
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for NewsComment', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->NewsComment->del($id)) {
			$this->Session->setFlash(__('NewsComment deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid NewsComment', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->NewsComment->save($this->data)) {
				$this->Session->setFlash(__('The NewsComment has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The NewsComment could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->NewsComment->read(null, $id);
		}
		$authors = $this->NewsComment->Author->find('list');
		$news = $this->NewsComment->News->find('list');
		$this->set(compact('authors','news'));
	}

	function admin_delete($id = null) {
		if($id) {
			if ($this->NewsComment->del($id)) {
				if($this->RequestHandler->isAjax()) {
					Configure::write('debug', 0);
					$this->render('ajax/admin_delete', 'ajax');
				}
				else {
					$this->Session->setFlash(__('Commentaire supprimé', true));
					$this->redirect(array('action'=>'index'));
				}
			}
		}
	}
	
	function admin_publish($id = null) {
		if($id) {
			$this->NewsComment->publish($id);
			if($this->RequestHandler->isAjax()) {
				Configure::write('debug', 0);
				$this->render('ajax/admin_delete', 'ajax');
				return;
			}
			$this->flash('Commentaire publié !', $this->referer());
		}
	}
	
	function admin_unpublish($id = null) {
		if($id) {
			$this->NewsComment->unpublish($id);
			if($this->RequestHandler->isAjax()) {
				Configure::write('debug', 0);
				$this->render('ajax/admin_delete', 'ajax');
				return;
			}
			$this->flash('Commentaire caché !', $this->referer());
		}
	}

}
?>