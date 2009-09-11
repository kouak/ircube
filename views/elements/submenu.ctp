<?php 
$subMenus = array();
$i = 1;
$actual = 0;
foreach($menuPrincipal as $nom => $valeur) {
	if (isset($valeur['Subitem'])) { /* C'est un item à sous menu */
		if(isset($valeur['actual'])) {
			$actual = $i;
		}
		$subMenus[$i] = $valeur['Subitem'];
		$i++;
	}
}
?>
<div id="submenubar" class="span-24 last">
<?php
/* Sous menus */
	for($i=1;isset($subMenus[$i]);$i++) {
?>
	<ul id="subitem<?php echo $i; ?>" class="<?php if($i == $actual) echo " visible"; ?>">
<?php
		foreach($subMenus[$i] as $n => $v) {
?>
		<li class="<?php if(isset($v['actual'])) echo " subitem_active"; ?>">
			<?php
				echo $html->link($v['title'], $v['Url'], array('title' => @$v['title']));
			?>
		</li>
<?php
		}
?>
	</ul>
<?php
	}
?>
</div>