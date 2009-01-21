<div class="channels form">
<?php echo $form->create('Channel');?>
	<fieldset>
 		<legend><?php __('Edit Channel');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('channel');
		echo $form->input('flag');
		echo $form->input('defmodes');
		echo $form->input('deftopic');
		echo $form->input('welcome');
		echo $form->input('description');
		echo $form->input('url');
		echo $form->input('motd');
		echo $form->input('banlevel');
		echo $form->input('chmodelevel');
		echo $form->input('bantype');
		echo $form->input('limit_inc');
		echo $form->input('limit_min');
		echo $form->input('bantime');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Channel.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Channel.id'))); ?></li>
		<li><?php echo $html->link(__('List Channels', true), array('action'=>'index'));?></li>
	</ul>
</div>
