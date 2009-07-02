<?php 
$subMenus = array();
$i = 1;
$actual = 0;
foreach($menuPrincipal as $nom => $valeur):
	if (isset($valeur['Item'])) { /* C'est un item à sous menu */
		if(isset($valeur['actual'])) {
			$actual = $i;
		}
		$subMenus[$i] = $valeur['Item'];
		$i++;
	}
endforeach;
?>
<div id="submenubar" class="span-24 last">
<?php
/* Sous menus */
	for($i=1;isset($subMenus[$i]);$i++):
?>
	<ul id="subitem<?php echo $i; ?>" class="<?php if($i == $actual) echo " visible"; ?>">
<?php
		foreach($subMenus[$i] as $n => $v):
?>
			
		<li class="<?php if(isset($v['actual'])) echo " subitem_active"; ?>">
			<?php
				if(isset($v['c']) && isset($v['a'])) {
					echo $html->link($v['label'], array('controller' => $v['c'], 'action' => $v['a']), array('title' => @$v['title']));
				} else {
					echo $html->link($v['label'], $v['url'], array('title' => @$v['title']));
				}
			?>
			
		</li>
<?php
		endforeach;
?>
	</ul>
<?php
	endfor;
?>
</div>