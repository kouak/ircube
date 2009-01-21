<div class="channels form">
<?php echo $form->create('Channel');?>
	<fieldset>
 		<legend><?php __('Add Channel');?></legend>
	<?php
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
		<li><?php echo $html->link(__('List Channels', true), array('action'=>'index'));?></li>
	</ul>
</div>
