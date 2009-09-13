<script type="text/javascript">
$(document).ready(function() {
	$('#CommentAddForm').submit(function() {
		$(this).ajaxSubmit({
			dataType: "html",
			success: function(responseText) {
				$('#comment_form').html(responseText);
				$('div.ircube-box > h1, div.ircube-box > h2, div.ircube-box > h3').corners("10px top");
				$('div.ircube-box > div.noheader').corners("10px");
				$('div.ircube-box > div.box').corners("10px bottom");
			}
		});
		return false;
	}); 
});
</script>
<?php
$content = $uniForm->create('Comment', array('url' => array('controller' => 'comments', 'action' => 'add'), 'fieldset' => array('blockLabels' => false)));
$content.= $uniForm->input('Comment.model_id', array('type' => 'hidden', 'value' => $model_id));
$content.= $uniForm->input('Comment.model', array('type' => 'hidden', 'value' => $model));
$content.= $uniForm->input('Comment.content', array('label' => __('Commentaire', true)));
$content.= $uniForm->submit();
$content.= $uniForm->end();
echo $this->element('ircube-box', array('options' => array('header' => 'h2'), 'title' => __('Laisser un commentaire', true), 'content' => $content));
?>