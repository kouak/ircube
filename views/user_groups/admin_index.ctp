<div>
	<table>
	<th>Controller Action</th>
	<?php
foreach($data as $p)
	echo '<th width="15%">'.$p['UserGroup']['title'].'</th>';
?>
	<?php
$first = true;

foreach($ctlist as $controller => $actions)
{
	if($first)
		echo '<tr>';
	else
		echo '<tr style="border-top: 1px solid; margin-top: 5px;">';

	echo '<td style="font-weight: bold">'.$controller.'</td>';

	foreach($data as $val)
	{
		echo '<td>';
		echo $ajax->link('Allow all', '/roles/adjustperm/'.$val['UserGroup']['id'].'/'.$controller.'/all/allow', array('update' => 'updacl'));
		echo '&nbsp;&nbsp;';
		echo $ajax->link( 'Deny all', '/roles/adjustperm/'.$val['UserGroup']['id'].'/'.$controller.'/all/deny', array('update' => 'updacl'));
		echo '</td>';
	}

	echo '</tr>';

	foreach($actions as $action => $perm)
	{
		echo '<tr>';
		echo '<td>'.$action.'</td>';

		foreach($perm as $key => $val)
		{
			if($val == 1)
				$st = 'style="color: #66CC00;"';
			else
				$st = 'style="color: #990000;"';
			echo '<td id="'.$controller.'_'.$action.'_'.$key.'" '.$st.'>';

			if($val == 1)
				echo 'allowed ' . $ajax->link( 'deny?', '/roles/adjustperm/'.$key.'/'.$controller.'/'.$action.'/deny', array('update' => 'updacl'));
			else
				echo 'denied ' . $ajax->link( 'allow?', '/roles/adjustperm/'.$key.'/'.$controller.'/'.$action.'/allow', array('update' => 'updacl'));

			echo '</td>';
		}

		echo '</tr>';
	}

	$first = false;
}
?>
</table>
</div>
<div id="updacl"></div>