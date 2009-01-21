<?php
class UserGroupsController extends AppController {

	var $name = 'UserGroups';
	var $helpers = array('Html', 'Form', 'Ajax');
	var $components = array('RequestHandler', 'Acl', 'ControllerList');
	var $uses = array('UserGroup');

	function admin_index() {
		$this->UserGroup->recursive = 0;
		$data = $this->UserGroup->findAll();
		$Controllers = Configure::listObjects('controller');
		
	    $controllerList = $this->ControllerList->get();

		// we loop on all action for all roles

		foreach($controllerList as $controller => $actions )
		{
			foreach($actions as $key => $action)
			{
				$controllerList[$controller][$action] = array();
				unset($controllerList[$controller][$key]);
				foreach($data as $p)
				{
					$controllerList[$controller][$action][$p['UserGroup']['id']] = $this->Acl->check($p, $controller . '/'. $action, '*');
				}
			}
		}
		//debug($controllerList);
		$this->set('ctlist', $controllerList);
		$this->set('data', $data);
	}
}
	
?>