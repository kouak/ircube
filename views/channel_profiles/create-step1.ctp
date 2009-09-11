<h1>Les salons qui n'ont pas de profil</h1>
<ul>
<?php
foreach($accesses as $a) {
	echo '<li>' . $html->link($a['Channel']['channel'], array('action' => 'create', substr($a['Channel']['channel'], 1))) . '</li>';
}
?>
</ul>