<div class="channelProfiles form">
<?php echo $form->create('ChannelProfile');?>
	<fieldset>
 		<legend><?php __('Edit ChannelProfile');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('channel_id');
		echo $form->input('description');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('ChannelProfile.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('ChannelProfile.id'))); ?></li>
		<li><?php echo $html->link(__('List ChannelProfiles', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Channels', true), array('controller'=> 'channels', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Channel', true), array('controller'=> 'channels', 'action'=>'add')); ?> </li>
	</ul>
</div>
