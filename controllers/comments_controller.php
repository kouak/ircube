<?php
class CommentsController extends AppController {

	var $name = 'Comments';
	var $helpers = array('Form', 'Paginator', 'Time', 'Ircube', 'Bbcode', 'Tinymce', 'Javascript', 'Gravatar', 'ProfileHelper');
	var $components = array('RequestHandler');
	var $uses = array('News', 'Comment', 'NewsType');

	function admin_index() {
		$this->placename = 'lastcomments';
		if($this->RequestHandler->isAjax()) {
			$this->paginate = array(
				'limit' => 10,
				'order' => array(
					'Comment.created' => 'desc'
					),
				'recursive' => 0,
				);
			$this->set('comments', $this->paginate('Comment'));
			Configure::write('debug', 0);
			$this->render('ajax/admin_index', 'ajax');
		}
	}

	function add() {
		if($this->RequestHandler->isAjax()) {
			Configure::write('debug', 0);
			if(!empty($this->data)) {
				$this->data['Comment']['author_id'] = $this->Auth->user('id') ? $this->Auth->user('id') : 0;
				/* TODO : read from configuration */
				$this->data['Comment']['status'] = 1;
				//App::import('Sanitize'); /* Data sanitization (should be done in view) */
				//$this->data['Comment']['content'] = Sanitize::html($this->data['Comment']['content']);
				if($this->Comment->save($this->data, array('fieldList' => array('model', 'author_id', 'content', 'model_id', 'status')))) {
					$this->Comment->recursive = 0;
					$this->set('comment', $this->Comment->read());
					$this->render('ajax/add_comment_success', 'ajax');
				}
				else {
					$this->set('model', $this->data['Comment']['model']);
					$this->set('model_id', $this->data['Comment']['model_id']);
					$this->render('ajax/add_comment_fail', 'ajax');
				}
			}
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for Comment', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Comment->del($id)) {
			$this->Session->setFlash(__('Comment deleted', true));
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
			if ($this->Comment->del($id)) {
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
	
	function view($id = null) {
		$this->Comment->contain(array('Author' => array('fields' => array('user_id', 'active', 'username'))));
		//$this->Comment->recursive = 1;
		if($id === null) {
			$this->cakeError('error404');
			return;
		}
		$comment = $this->Comment->findById($id);
		if(empty($comment)) {
			$this->cakeError('error404');
			return;
		}
		$this->set('comment', $comment);
	}
	
	function display($model = null, $id = null) {
		if($model === null || $id === null) {
			$this->cakeError('error404');
			return;
		}
		
		Configure::write('debug', 0);
		$model = Inflector::camelize((string) $model);
		$id = (integer) $id;
		
		/* Retrieve order and limit from config file */
		$fallback = array( /* This array should never be used */
			'order' => array('Comment.created' => 'desc'),
			'limit' => 40,
		);
		
		$params = array_merge($fallback, (array) Configure::read('Comments.default'), (array) Configure::read('Comments.' . $model)); /* Merge arrays */
		
		$this->paginate = array(
			'conditions' => array(
				'Comment.model' => $model,
				'Comment.model_id' => $id,
				'Comment.status' => 1, /* published status */
			),
			'order' => $params['order'],
			'contain' => array('Author' => array('fields' => array('active', 'username', 'user_id'))),
			'limit' => $params['limit'],
		);
		
		$this->set('comments', $this->paginate('Comment'));
		if($this->RequestHandler->isAjax()) {
			$this->render('ajax/display', 'ajax');
		}
	}
	
	function admin_publish($id = null) {
		if($id) {
			$this->Comment->publish($id);
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
			$this->Comment->unpublish($id);
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