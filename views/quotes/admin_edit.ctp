<div class="quotes form">
<?php echo $form->create('Quote');?>
	<fieldset>
 		<legend><?php __('Edit Quote');?></legend>
	<?php
		echo $form->input('id');
		echo $form->input('user_profile_id');
		echo $form->input('channel_profile_id');
		echo $form->input('titre');
		echo $form->input('texte');
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Delete', true), array('action'=>'delete', $form->value('Quote.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $form->value('Quote.id'))); ?></li>
		<li><?php echo $html->link(__('List Quotes', true), array('action'=>'index'));?></li>
	</ul>
</div>
