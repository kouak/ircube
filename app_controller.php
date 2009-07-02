<?php
class AppController extends Controller {
	var $helpers = array('Html', 'Form', 'UniForm', 'Session', 'Javascript', 'Text', 'ProfileHelper', 'Ircube', 'Time'); /* Html & Sessions already included */
	var $uses = array('MenuPrincipal', 'UserProfile', 'User');
	var $components = array('Acl', 'Auth', 'Session', 'RequestHandler');
	var $placename; /* Utilisée par le menu principal : condition $placename == $label['id'] */
	
	function beforeRender() {
		//On définit l'endroit ou l'on se trouve actuellement (pour le menu)
		if (isset($this->placename)) { /* Si placename a été défini dans le controller */ 
			$placename = $this->placename;
		} else {
			$placename = strtolower($this->name);
		}

		$admin = Configure::read('Routing.admin');
		if (isset($this->params[$admin]) && $this->params[$admin]) {
			$this->set('adminPanel', true);
			$this->layout = 'admin';
			$this->set('menuPrincipal', $this->MenuPrincipal->makeAdminMenu($placename));
			$this->set('menuActual', $placename);
		} else {
			$this->set('adminPanel', false);
			$this->set('menuPrincipal', $this->MenuPrincipal->makeMenu($placename));
			$this->set('menuActual', $placename);
		}
		return true;
	}

    function beforeFilter() {
	
		$this->Auth->userModel = 'UserProfile';
		$this->Auth->fields = array(
			'username' => 'username', 
			'password' => 'password'
			);
		$this->Auth->authenticate = $this->UserProfile;
		$this->Auth->loginAction = array('admin' => false, 'controller' => 'user_profiles', 'action' => 'login');
		$this->Auth->authorize = 'actions';
		$this->Auth->authError = "Vous ne disposez pas des droits nécessaires pour voir cette page.";
		$this->Auth->loginError = "Login incorrect.<br />"
		."<span id=\"create_account\"><a href=\"". Router::url(array('controller' => 'user_profiles', 'action' => 'create_profile')) . "\">Vous n'avez pas de compte ?</a></span>";
		$this->Auth->loginRedirect = array('controller'=>'news', 'action'=>'home');
		$this->Auth->userScope = array('UserProfile.active' => 1);
		$this->Auth->autoRedirect = false;
		
		if(!$this->Auth->user()) { /* User not logged in, consider as a Guest */
			if ($this->Acl->check("Guest", $this->Auth->action())) {
				$this->Auth->allow();
			}
			$this->set('AuthUser', array());
		}
		else { /* User is currently logged in */
			$this->UserProfile->contain(array('User' => array('Data' => array('conditions' => array('Data.flag & 0x8'))))); /* Try to find current user suspend state */
			$userProfile = $this->UserProfile->findById($this->Auth->user('id'));
			
			
			if(!is_numeric($userProfile['User']['id'])) { /* User does not exist anymore */
				$this->Session->setFlash('Votre compte a été supprimé.');
				$this->redirect($this->Auth->logout());
			}


			
			if(strtotime($userProfile['UserProfile']['modified']) > strtotime($this->Auth->user('modified')) || strtotime($userProfile['User']['modified']) > strtotime($this->Auth->user('modified'))) { /* User's has changed */
				//update the auth userModel data
				$this->UserProfile->syncProfile($this->Auth->user('id')); /* Update current UserProfile */
				//$userProfile['UserProfile']['lastseen'] = date('Y-m-d H:i:s');
				unset($userProfile['UserProfile']['password']);
				unset($userProfile['UserProfile']['lastseen']);
				$authUpdated = Set::merge(
				    $this->Session->read(
				        sprintf('Auth.%s', $this->Auth->userModel)
				    ),
				    $userProfile['UserProfile']
				);
				$this->Session->write(
				    sprintf('Auth.%s', $this->Auth->userModel),
				    $authUpdated
				);
			}
			
			
			if($this->UserProfile->User->isSuspended($userProfile)) { /* User is suspended */
				$this->Session->setFlash(	'Votre compte a été suspendu.<br />' .
											'Suspendu par : ' . $userProfile['User']['Data'][0]['sender'] . '<br />'.
											'Expire : ' . $userProfile['User']['Data'][0]['expire'] . '<br />' .
											'Raison : ' . $userProfile['User']['Data'][0]['raison'] . '<br />'
											);
				$this->redirect($this->Auth->logout());
			}
			

			$this->UserProfile->id = $userProfile['UserProfile']['id'];
			$this->UserProfile->save(array('UserProfile' => array('lastseen' => date('Y-m-d H:i:s'), 'modified' => $userProfile['UserProfile']['modified'])));
			
			$this->set('AuthUser', reset($this->Auth->user()));

		}

    }

}
?>