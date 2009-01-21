<div class="channels index">
<h2><?php __('Channels');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('channel');?></th>
	<th><?php echo $paginator->sort('flag');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('defmodes');?></th>
	<th><?php echo $paginator->sort('deftopic');?></th>
	<th><?php echo $paginator->sort('welcome');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th><?php echo $paginator->sort('url');?></th>
	<th><?php echo $paginator->sort('motd');?></th>
	<th><?php echo $paginator->sort('banlevel');?></th>
	<th><?php echo $paginator->sort('chmodelevel');?></th>
	<th><?php echo $paginator->sort('bantype');?></th>
	<th><?php echo $paginator->sort('limit_inc');?></th>
	<th><?php echo $paginator->sort('limit_min');?></th>
	<th><?php echo $paginator->sort('bantime');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($channels as $channel):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $channel['Channel']['id']; ?>
		</td>
		<td>
			<?php echo $channel['Channel']['channel']; ?>
		</td>
		<td>
			<?php echo $channel['Channel']['flag']; ?>
		</td>
		<td>
			<?php echo $channel['Channel']['modified']; ?>
		</td>
		<td>
			<?php echo $channel['Channel']['created']; ?>
		</td>
		<td>
			<?php echo $channel['Channel']['defmodes']; ?>
		</td>
		<td>
			<?php echo $channel['Channel']['deftopic']; ?>
		</td>
		<td>
			<?php echo $channel['Channel']['welcome']; ?>
		</td>
		<td>
			<?php echo $channel['Channel']['description']; ?>
		</td>
		<td>
			<?php echo $channel['Channel']['url']; ?>
		</td>
		<td>
			<?php echo $channel['Channel']['motd']; ?>
		</td>
		<td>
			<?php echo $channel['Channel']['banlevel']; ?>
		</td>
		<td>
			<?php echo $channel['Channel']['chmodelevel']; ?>
		</td>
		<td>
			<?php echo $channel['Channel']['bantype']; ?>
		</td>
		<td>
			<?php echo $channel['Channel']['limit_inc']; ?>
		</td>
		<td>
			<?php echo $channel['Channel']['limit_min']; ?>
		</td>
		<td>
			<?php echo $channel['Channel']['bantime']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $channel['Channel']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $channel['Channel']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $channel['Channel']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $channel['Channel']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $paginator->numbers();?>
	<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class'=>'disabled'));?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('New Channel', true), array('action'=>'add')); ?></li>
	</ul>
</div>
