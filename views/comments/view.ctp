<ol class="commentlist" id="commentlist">
<?php
echo $this->html->css(array('comments'), null, array('inline' => false));
echo $this->element('comment', array('i' => $comment['Comment']['id'], 'comment' => $comment));
?>
</ol>