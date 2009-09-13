<?php
if(isset($comment['Comment']['status']) && $comment['Comment']['status'] == 0) {
	echo $this->element('ircube-box', array('options' => array('color' => 'green'), 'content' => __('Votre commentaire a été enregistré, il doit être validé pour être visible', true)));
} 
else {
	echo $this->element('comment', array('comment' => am($comment['Comment'], array('Author' => $comment['Author'])), 'i' => $comment['News']['comment_count']));
}
?>