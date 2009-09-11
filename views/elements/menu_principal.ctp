<div id="menubar" class="span-24 last">
	<ul>
<?php 
$subMenus = array();
$i = 1;
$actual = 0;
foreach($menuPrincipal as $nom => $valeur) {
	if (isset($valeur['Subitem'])) { /* C'est un item à sous menu */
		if(isset($valeur['actual'])) {
			$actual = $i;
		}
?>
		<li id="submenu<?php echo $i; ?>" class="<?php 
		if(isset($valeur['actual'])) echo " clicked main_active";
		if($valeur == end($menuPrincipal)) echo " last";
		
		?>">
			<a name="<?php echo $valeur['label'];?>"><?php echo $valeur['title'];?></a>
		</li>
<?php
	$i++;
	} else {
?>
		<li class="<?php 
		if(isset($valeur['actual'])) echo " clicked main_active"; 
		if($valeur == end($menuPrincipal)) echo " last";
		?>">
			<?php
				echo $html->link($valeur['title'], $valeur['Url'], array('title' => @$valeur['label']));
			?>

		</li>
<?php		
	}
}
?>
	</ul>
</div>