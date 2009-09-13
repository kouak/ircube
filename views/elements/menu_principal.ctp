<div id="menubar" class="span-24 last">
	<ul>
<?php 
$subMenus = array();
$i = 1;
$actual = 0;
foreach($menuPrincipal as $nom => $valeur) {
	if (isset($valeur['Topitem']['Subitem'])) { /* C'est un item à sous menu */
		if(isset($valeur['Topitem']['actual'])) {
			$actual = $i;
		}
?>
		<li id="submenu<?php echo $i; ?>" class="<?php 
		if(isset($valeur['Topitem']['actual'])) echo " clicked main_active";
		if($valeur == end($menuPrincipal)) echo " last";
		
		?>">
			<a name="<?php echo @$valeur['Topitem']['label'];?>"><?php echo $valeur['Topitem']['title'];?></a>
		</li>
<?php
	$i++;
	} else {
?>
		<li class="<?php 
		if(isset($valeur['Topitem']['actual'])) echo " clicked main_active"; 
		if($valeur == end($menuPrincipal)) echo " last";
		?>">
			<?php
				echo $html->link($valeur['Topitem']['title'], $valeur['Topitem']['Url'], array('title' => @$valeur['Topitem']['label']));
			?>

		</li>
<?php		
	}
}
?>
	</ul>
</div>