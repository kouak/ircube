<div class="news form">
<?php echo $form->create('News');?>
	<fieldset>
 		<legend><?php __('Edit News');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('newstype_id');
		echo $form->input('title');
		echo $form->input('content');
		echo $form->input('user_id');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('News.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('News.id'))); ?></li>
		<li><?php echo $html->link(__('List News', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Newstypes', true), array('controller'=> 'newstypes', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Newstype', true), array('controller'=> 'newstypes', 'action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Users', true), array('controller'=> 'users', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New User', true), array('controller'=> 'users', 'action'=>'add')); ?> </li>
	</ul>
</div>