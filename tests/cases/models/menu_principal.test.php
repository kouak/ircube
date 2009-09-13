<?php
/* MenuPrincipal Test cases generated on: 2009-09-12 18:09:05 : 1252773965*/
App::import('Model', 'MenuPrincipal');

class MenuPrincipalTestCase extends CakeTestCase {
	var $fixtures = array('app.menu_principal');

	function startTest() {
		$this->MenuPrincipal =& ClassRegistry::init('MenuPrincipal');
	}

	function endTest() {
		unset($this->MenuPrincipal);
		ClassRegistry::flush();
	}

	function testMakeAdminMenu() {

	}

	function testMakeMenu() {

	}

}
?>