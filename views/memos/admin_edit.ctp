<div class="memos form">
<?php echo $form->create('Memo');?>
	<fieldset>
 		<legend><?php __('Edit Memo');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('user_id');
		echo $form->input('sender_id');
		echo $form->input('lastupdated');
		echo $form->input('flag');
		echo $form->input('sender');
		echo $form->input('content');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Memo.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Memo.id'))); ?></li>
		<li><?php echo $html->link(__('List Memos', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
	</ul>
</div>
