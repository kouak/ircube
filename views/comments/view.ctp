<ol class="commentlist" id="commentlist">
<?php
echo $this->Html->css(array('comments'), null, array(), false);
echo $this->element('comment', array('i' => $comment['Comment']['id'], 'comment' => $comment));
?>
</ol>