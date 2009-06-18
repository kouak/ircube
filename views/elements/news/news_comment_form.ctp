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
echo $form->create('NewsComment', array('url' => array('controller' => 'news_comments', 'action' => 'add')));
echo $form->input('NewsComment.news_id', array('type' => 'hidden', 'value' => $news_id));
echo $form->input('NewsComment.content', array('label' => false));
//echo $form->input('NewsComment.user_profile_id', array('style' => 'display: none;', 'label' => 'none'));
echo $form->submit();
echo $form->end();
?>