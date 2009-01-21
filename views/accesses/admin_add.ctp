<div class="accesses form">
<?php echo $form->create('Access');?>
	<fieldset>
 		<legend><?php __('Add Access');?></legend>
	<?php
		echo $form->input('flag');
		echo $form->input('lastseen');
		echo $form->input('channel_id');
		echo $form->input('user_id');
		echo $form->input('channel_name');
		echo $form->input('user_name');
		echo $form->input('level');
		echo $form->input('info');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Accesses', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Channels', true), array('controller'=> 'channels', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Channel', true), array('controller'=> 'channels', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
	</ul>
</div>
