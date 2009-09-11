<div class="channelProfiles index">
<h2><?php __('ChannelProfiles');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('id');?></th>
	<th><?php echo $paginator->sort('created');?></th>
	<th><?php echo $paginator->sort('modified');?></th>
	<th><?php echo $paginator->sort('Channel', 'Channel.channel');?></th>
	<th><?php echo $paginator->sort('description');?></th>
	<th class="actions"><?php __('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($channelProfiles as $channelProfile):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $channelProfile['ChannelProfile']['id']; ?>
		</td>
		<td>
			<?php echo $channelProfile['ChannelProfile']['created']; ?>
		</td>
		<td>
			<?php echo $channelProfile['ChannelProfile']['modified']; ?>
		</td>
		<td>
			<?php echo $html->link($channelProfile['Channel']['channel'], array('action'=>'view', 'channel' => cleanChannelName('###'. $channelProfile['Channel']['channel'], array('urlencode')))); ?>
		</td>
		<td>
			<?php echo $channelProfile['ChannelProfile']['description']; ?>
		</td>
		<td class="actions">
			<?php echo $html->link(__('View', true), array('action'=>'view', $channelProfile['ChannelProfile']['id'])); ?>
			<?php echo $html->link(__('Edit', true), array('action'=>'edit', $channelProfile['ChannelProfile']['id'])); ?>
			<?php echo $html->link(__('Delete', true), array('action'=>'delete', $channelProfile['ChannelProfile']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $channelProfile['ChannelProfile']['id'])); ?>
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
		<li><?php echo $html->link(__('New ChannelProfile', true), array('action'=>'add')); ?></li>
		<li><?php echo $html->link(__('List Channels', true), array('controller'=> 'channels', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Channel', true), array('controller'=> 'channels', 'action'=>'add')); ?> </li>
	</ul>
</div>
