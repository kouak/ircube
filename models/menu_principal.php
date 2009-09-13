<?php	
class MenuPrincipal extends AppModel {
	var $name = 'MenuPrincipal';
	var $useTable = false;
	
	function __xmlToMenu($xml, $actual = '') {
		$menu = $xml->toArray();
		$menu = Set::extract('/Menu/Topitem', $menu);
		/* Add actual key */
		foreach($menu as $key => $value) {
			if(low($actual) == low($value['Topitem']['label'])) {
				$menu[$key]['Topitem']['actual'] = 1;
				break;
			}
			if(isset($value['Topitem']['Subitem']) && !empty($value['Topitem']['Subitem'])) {
				foreach($value['Topitem']['Subitem'] as $k => $v) {
					if(low($actual) == $v['label']) {
						$menu[$key]['Topitem']['actual'] = 1;
						$menu[$key]['Topitem']['Subitem'][$k]['actual'] = 1;
						break;
					}
				}
			}
		}
		return $menu;
	}
	
	function makeAdminMenu($actual = null) {
		return $this->makeMenu($actual, 'menu_admin.xml');
	}
	
	function makeMenu($actual = null, $filename = 'menu_principal.xml') {
		if ($actual == null) {
			$actual = 'accueil';
		}
		App::import('Xml');

		$file = APP . 'xml' . DS . $filename;

		// now parse it
		$parsed_xml =& new XML($file);

		return $this->__xmlToMenu($parsed_xml, $actual);
		
		$xml = simplexml_load_file($file);
				
		$menu = array();
		
		foreach($xml->item as $item) 
		{
			$menu[(string) $item['id']] = array(
				'label' => (string) $item['label'],
				'url' => (string) $item['url'],
				'title' => (string) $item['title'],
				);
			if ($actual == (string) $item['id']) 
			{
				$menu[(string) $item['id']]['actual'] = 1;
			}
			//On parcourt les sous-menus
			foreach($item->item as $it) 
			{
				$menu[(string) $item['id']]['item'][(string) $it['id']] = array(
					'label' => (string) $it['label'],
					'url' => (string) $it['url'],
					'title' => (string) $it['title'],
					);
				if ($actual == (string) $it['id']) 
				{
					$menu[(string) $item['id']]['actual'] = 1;
					$menu[(string) $item['id']]['item'][(string) $it['id']]['actual'] = 1;
				}
			}
		}
		debug($menu);
		return $menu;
	}
}
?>