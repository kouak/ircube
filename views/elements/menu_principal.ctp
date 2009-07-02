<div id="menubar" class="span-24 last">
	<ul>
<?php 
$subMenus = array();
$i = 1;
$actual = 0;
foreach($menuPrincipal as $nom => $valeur):
	if (isset($valeur['Item'])): /* C'est un item à sous menu */
		if(isset($valeur['actual'])) {
			$actual = $i;
		}
?>
		<li id="submenu<?php echo $i; ?>" class="<?php 
		if(isset($valeur['actual'])) echo " clicked main_active";
		if($valeur == end($menuPrincipal)) echo " last";
		
		?>">
			<a name="<?php echo $valeur['label'];?>"><?php echo $valeur['label'];?></a>
		</li>	
<?php
/* Construction sous-menus */
		$subMenus[$i] = $valeur['Item'];
		$i++;
?>
<?php
	else:
?>
		<li class="<?php 
		if(isset($valeur['actual'])) echo " clicked main_active"; 
		if($valeur == end($menuPrincipal)) echo " last";
		?>">
			<?php
				if(isset($valeur['a']) && isset($valeur['c'])) {
					echo $html->link($valeur['label'], array('controller' => $valeur['c'], 'action' => $valeur['a']), array('title' => @$valeur['title']));
				} else {
					echo $html->link($valeur['label'], $valeur['url'], array('title' => @$valeur['title']));
				}
			
			?>

		</li>
<?php		
	endif;
endforeach;
?>
	</ul>
</div>