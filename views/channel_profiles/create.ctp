<div class="channelProfiles form">

<?php echo $uniForm->create('ChannelProfile', array('url' => array('action' => $this->action, $this->params['pass'][0])));?>
	<fieldset>
 		<legend><?php __('Add ChannelProfile');?></legend>
	<?php
		echo $uniForm->input('description');
	?>
	</fieldset>
<?php echo $uniForm->end('Submit');?>
</div>
