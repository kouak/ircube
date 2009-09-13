<?php
$javascript->link(array('jquery/jquery.fcbkcomplete'), false);
$html->css(array('jquery/fcbkcomplete'), null, array(), false);
?>
<script type="text/javascript">
$(function() {
	$("#channels").fcbkcomplete({
		'json_url': "<?php echo Router::url(array('controller' => 'channels', 'action' => 'autoComplete')); ?>",
		'cache': false,
		'newel': false,
		'firstselected': true,
		'complete_text': "Indiquez les salons que vous fréquentez"
	});
});
</script>
<div class="quotes form">
<?php echo $uniForm->create('Quote'); ?>
	<fieldset>
 		<legend><?php __('Add Quote');?></legend>
	<?php
		echo $uniForm->input('channel');
		echo $uniForm->input('title');
		echo $uniForm->input('content');
	?>
	</fieldset>
<?php echo $uniForm->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Quotes', true), array('action'=>'index'));?></li>
	</ul>
</div>
