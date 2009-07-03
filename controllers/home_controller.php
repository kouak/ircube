<?php
class HomeController extends AppController {
	var $name = 'Home';
	var $uses = array();
	var $helpers = array('gravatar');
	
	function index() {
		$this->placename = 'Accueil';
		
		if(!$this->Auth->user()) {
			$this->loadModel('News');
			$this->set('latestNews', $this->News->latest());
			$this->render('/pages/home');
		}
		else {
			$this->loadModel('News');
			$this->set('latestNews', $this->News->latest());
			$this->render('/user_profiles/dashboard');
		}
	}
}
?>