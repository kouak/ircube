<ol class="comments" id="commentlist">
<?php
echo $this->Html->css(array('comments'), null, array('inline' => false));
echo $this->element('comment', array('i' => $comment['Comment']['id'], 'comment' => $comment));
?>
</ol>