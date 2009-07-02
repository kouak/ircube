<h2><?php __('Laisser un commentaire'); ?></h2>
<script type="text/javascript">
$(document).ready(function() {
	$('#NewsCommentAddForm').submit(function() {
		$(this).ajaxSubmit({
			dataType: "html",
			success: function(responseText) {
				$('#news_comment_form').html(responseText);
			}
		});
		return false;
	}); 
});
</script>
<?php
echo $uniForm->create('NewsComment', array('url' => array('controller' => 'news_comments', 'action' => 'add'), 'fieldset' => array('blockLabels' => false)));
echo $uniForm->input('NewsComment.news_id', array('type' => 'hidden', 'value' => $news_id));
echo $uniForm->input('NewsComment.content', array('label' => __('Commentaire', true)));
//echo $form->input('NewsComment.user_profile_id', array('style' => 'display: none;', 'label' => 'none'));
echo $uniForm->submit();
echo $uniForm->end();
?>