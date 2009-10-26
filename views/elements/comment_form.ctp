<?php 
echo $this->Javascript->link(array('jquery/jquery-form'), false);
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#CommentAddForm').submit(function() {
		$(this).ajaxSubmit({
			dataType: "html",
			success: function(responseText) {
				$('#comment_form').remove();
				$('div#comments > ol#commentlist').append(responseText);
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
echo $this->Ircube->startBox(array('header' => 'h2'));
echo $this->Ircube->boxTitle(__('Laisser un commentaire', true));
echo $this->Ircube->startBoxContent();
echo $this->UniForm->create('Comment', array('url' => array('controller' => 'comments', 'action' => 'add'), 'fieldset' => array('blockLabels' => false)));
echo $this->UniForm->input('Comment.model_id', array('type' => 'hidden', 'value' => $model_id));
echo $this->UniForm->input('Comment.model', array('type' => 'hidden', 'value' => $model));
echo $this->UniForm->input('Comment.content', array('label' => __('Commentaire', true)));
echo $this->UniForm->submit();
echo $this->UniForm->end();
echo $this->Ircube->endBox();
?>