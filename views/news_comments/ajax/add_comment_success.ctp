<?php
if(isset($comment['NewsComment']['published']) && $comment['NewsComment']['published'] == 0) {
	echo $this->element('ircube-box', array('options' => array('color' => 'green'), 'content' => __('Votre commentaire a été enregistré, il doit être validé pour être visible', true)));
} 
else {
	echo $this->element('comment', array('comment' => am($comment['NewsComment'], array('Author' => $comment['Author'])), 'i' => $comment['News']['news_comment_count']+1));
}
?>