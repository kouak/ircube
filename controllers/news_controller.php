<?php
class NewsController extends AppController {

	var $name = 'News';
	var $helpers = array('Form', 'Paginator', 'Time', 'Tinymce', 'Javascript', 'Gravatar', 'ProfileHelper');
	var $components = array('RequestHandler');
	var $uses = array('News', 'Comment', 'NewsType');

	var $paginate = array(
		'limit' => 1,
		'order' => array(
			'News.created' => 'desc'
			)
		);
		
	function beforeFilter() {
		$this->placename = 'news';
		parent::beforeFilter();
		$canEdit = false;
		$this->set('canEdit', $canEdit);
	}
	
	
	function admin_publish($id = null) {
		$this->News->publish($id);
		if($this->RequestHandler->isAjax()) {
			$this->set('news', $this->News->findById($id));
			Configure::write('debug', 0);
			$this->render('ajax/publish', 'ajax');
			return;
		}
		$this->flash('News publiée !', $this->referer());
	}
	
	function admin_unpublish($id = null) {
		$this->News->unpublish($id);
		if($this->RequestHandler->isAjax()) {
			$this->set('news', $this->News->findById($id));
			Configure::write('debug', 0);
			$this->render('ajax/publish', 'ajax');
			return;
		}
		$this->flash('News dépubliée !', $this->referer());
	}
	
	function admin_index() {
		if($this->RequestHandler->isAjax()) {
			$this->paginate = array(
				'limit' => 10,
				'order' => array(
					'News.created' => 'desc'
					),
				'contain' =>  array(
					'NewsType',
					'Author' => array('fields' => array('username', 'active', 'user_id'))
					),
				);
			$this->set('news', $this->paginate('News'));
			Configure::write('debug', 0);
			$this->render('ajax/admin_index', 'ajax');
		}
	}
	
	function index($c = null) {
		$this->placename = 'news';
		$this->paginate = array(
			'limit' => 3,
				'conditions' => array('News.published' => 1),
				'order' => array(
				'News.created' => 'desc'
				),
			'contain' =>  array(
				'NewsType',
				'Author' => array('fields' => array('username', 'active', 'user_id'))
				),
			);
		
		if($c) { /* Let's add some fields and conditions */
			$this->NewsType->contain(array());
			$cat = $this->NewsType->findByTitre($c);
			
			if(empty($cat)) {
				$this->Session->setFlash(__('La catégorie <i>'.$c.'</i> n\'existe pas', true), 'messages/failure');
				$this->redirect(array('action' => 'index'), 302);
				
			}
			$this->paginate['conditions'] = array_merge(array('NewsType.titre' => $c), (array)@$this->paginate['conditions']);
		}
		
		$this->pageTitle = __('Archives des actualités', true);
		$nttmp = $this->News->NewsType->find('list'); 
		/* Build up a 'url => title' list for the select box */
		$nt = array();
		if(!empty($cat)) {
			$this->pageTitle .= __(' - Catégorie : ', true). $cat['NewsType']['titre'];
			$k = Router::url(array('action'=>'index')); /* Unfilter */
			$nt[$k] = __('Tous', true);
		}
		
		foreach($nttmp as $k => $v)	{
			if(isset($cat['NewsType']['id']) && $k == $cat['NewsType']['id']) /* Skip current newstype, will be displayed in the views as empty option */
				continue;
			$k = Router::url(array('action'=>'index', 'cat' => $v));
			$nt[$k] = $v;
		}

		
		$this->set('newstypes', $nt);
		$this->set('news', $this->paginate('News'));
	}
	
	function home() 
	{
		if(stristr($this->params['url']['url'], $this->name)) /* Lien vers le controleur => redirect vers / */
		{
			$this->redirect('/', 301);
			die();
		}
		
		$this->placename = 'accueil';
		
		$this->News->contain(array('NewsType',
									//'NewsComment', /* Remove if countCache fails */
									'Author' => array('fields' => array('username', 'active', 'user_id'))
									)
							);

							
		$n = $this->News->find('all', array(	'limit' => 3,
												'conditions' => array('News.published' => 1),
												'order' => array(
														'News.created' => 'desc'
														)
												)
									);
		
		$this->set('news', $n);
	}

	/* View individual news */
	function view($id = null,$permalink = null) {
		if ($id == null || $permalink == null) {
			$this->redirect(array('action'=>'index'), 301);
		}
		$this->News->contain(array('NewsType',
									'Comment' => array(
										'conditions'=> array('Comment.model' => 'News', 'Comment.status' => 1),
										'Author' => array('Avatar', 'fields' => array('username', 'mail', 'active', 'user_id'))
										),
									'Author' => array(
										'fields' => array('username', 'user_id', 'active')
										)
									)
							); /* Limit sql JOINs */
		
		$news = $this->News->findById($id);
		
		if(empty($news)) { /* No news found with this id */
			$this->Session->setFlash('La news correspondante n\'existe pas', 'messages/failure');
			$this->redirect(array('action' => 'index'), 303);
		}
		
		if($news['News']['permalink'] != $permalink) { /* Weird URL ? Redirect to the good one */
			$this->redirect(array('action'=>'view', 'id' => $id, 'slug' => $news['News']['permalink']), 301);
		}
		
		$this->set('news', $news);
	}
	
	function admin_edit($id = null) {
		$this->placename = 'postnews';
		if (!empty($this->data)) {
			if(isset($id)) { /* Edit mode, keep current author */
				unset($this->data['News']['user_profile_id']);
			}
			else { /* Add mode, pick up current Author id from session */
				$this->data['News']['user_profile_id'] = $this->Auth->user('id') ? $this->Auth->user('id') : 0;
			}
			if ($this->News->save($this->data))	{
				$this->Session->setFlash(__('La news a été sauvegardée', true), 'messages/success');
				$this->redirect(array('action'=>'index'));
			} 
			else {
				$this->Session->setFlash(__('Une erreur s\'est produite, corrigez les erreurs indiquées', true), 'messages/failure');
			}
		}
		if (isset($id)) { /* We have an id, but nothing was posted => bring up the edit form */
			$this->data = $this->News->read(null, $id);
			if(empty($this->data)) { /* No news with this id, raise an error */
				$this->Session->setFlash(__('La news correspondante n\'existe pas', true), 'messages/failure');
				$this->redirect($this->referer());
			}
			$newstypes = $this->News->NewsType->find('list', array('fields' => 'NewsType.titre'));
			$this->set(compact('newstypes'));
			$this->set('addnews', false);
		}
		else {
			$newstypes = $this->News->NewsType->find('list', array('fields' => 'NewsType.titre'));
			$this->set(compact('newstypes'));
			$this->set('addnews', true);
		}
		
	}
	
	function admin_delete($id = null) {
		if($id) {
			if ($this->News->del($id)) {
				if($this->RequestHandler->isAjax()) {
					Configure::write('debug', 0);
					$this->render('ajax/admin_delete', 'ajax');
				}
				else {
					$this->Session->setFlash(__('News deleted', true));
					$this->redirect(array('action'=>'index'));
				}
			}
		}
	}

}
?>