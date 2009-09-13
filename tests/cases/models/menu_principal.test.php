<?php
/* MenuPrincipal Test cases generated on: 2009-09-12 18:09:05 : 1252773965*/
App::import('Model', 'MenuPrincipal');
App::import('Core', 'Xml');

class MenuPrincipalTestCase extends CakeTestCase {
	var $fixtures = array();
	


	function startTest() {
		$this->MenuPrincipal =& ClassRegistry::init('MenuPrincipal');
	}

	function endTest() {
		unset($this->MenuPrincipal);
		ClassRegistry::flush();
	}

	function test__xmlToMenu() {
		$source = '
			<?xml version="1.0" encoding="utf-8"?>
			<menu>
				<Topitem>
					<title>Accueil</title>
					<Url>/</Url>
					<label>accueil</label>
				</Topitem>
				<Topitem>
					<title>News</title>
					<Url>
						<controller>news</controller>
						<action>index</action>
					</Url>
					<label>news</label>
				</Topitem>
				<Topitem>
					<title>Communauté</title>
					<label>communauté</label>
					<Subitem>
						<title>Trombinoscope</title>
						<label>trombinoscope</label>
						<Url>
							<controller>user_profiles</controller>
							<action>index</action>
						</Url>
					</Subitem>
					<Subitem>
						<title>Quotes</title>
						<label>quotes</label>
						<Url>
							<controller>quotes</controller>
							<action>index</action>
						</Url>
					</Subitem>
				</Topitem>
			</menu>
		';
		$expected = array(
			array(
				'Topitem' => array(
					'title' => 'Accueil',
					'label' => 'accueil',
					'Url' => '/',
				),
			),
			array(
				'Topitem' => array(
					'title' => 'News',
					'label' => 'news',
					'Url' => array('controller' => 'news', 'action' => 'index'),
				),
			),
			array(
				'Topitem' => array(
					'title' => 'Communauté',
					'label' => 'communauté',
					'Subitem' => array(
						array(
							'title' => 'Trombinoscope',
							'label' => 'trombinoscope',
							'Url' => array('controller' => 'user_profiles', 'action' => 'index')
						),
						array(
							'title' => 'Quotes',
							'label' => 'quotes',
							'Url' => array('controller' => 'quotes', 'action' => 'index')
						),
					),
				),
			),
		);
		$xml = new Xml($source);
		$this->assertEqual($expected, $this->MenuPrincipal->__xmlToMenu($xml));
		
		$expected = array(
			array(
				'Topitem' => array(
					'title' => 'Accueil',
					'label' => 'accueil',
					'Url' => '/',
				),
			),
			array(
				'Topitem' => array(
					'title' => 'News',
					'label' => 'news',
					'actual' => 1,
					'Url' => array('controller' => 'news', 'action' => 'index'),
				),
			),
			array(
				'Topitem' => array(
					'title' => 'Communauté',
					'label' => 'communauté',
					'Subitem' => array(
						array(
							'title' => 'Trombinoscope',
							'label' => 'trombinoscope',
							'Url' => array('controller' => 'user_profiles', 'action' => 'index')
						),
						array(
							'title' => 'Quotes',
							'label' => 'quotes',
							'Url' => array('controller' => 'quotes', 'action' => 'index')
						),
					),
				),
			),
		);
		
		$this->assertEqual($expected, $this->MenuPrincipal->__xmlToMenu($xml, 'news'));
		
		$expected = array(
			array(
				'Topitem' => array(
					'title' => 'Accueil',
					'label' => 'accueil',
					'Url' => '/',
				),
			),
			array(
				'Topitem' => array(
					'title' => 'News',
					'label' => 'news',
					'Url' => array('controller' => 'news', 'action' => 'index'),
				),
			),
			array(
				'Topitem' => array(
					'title' => 'Communauté',
					'label' => 'communauté',
					'actual' => 1,
					'Subitem' => array(
						array(
							'title' => 'Trombinoscope',
							'label' => 'trombinoscope',
							'actual' => 1,
							'Url' => array('controller' => 'user_profiles', 'action' => 'index')
						),
						array(
							'title' => 'Quotes',
							'label' => 'quotes',
							'Url' => array('controller' => 'quotes', 'action' => 'index')
						),
					),
				),
			),
		);
		
		$this->assertEqual($expected, $this->MenuPrincipal->__xmlToMenu($xml, 'TROMBInoScOpE'));
	}

}
?>