<?php
echo $this->element('comment', array('comment' => am($comment['NewsComment'], array('Author' => $comment['Author'])), 'i' => $comment['News']['news_comment_count']));
?>