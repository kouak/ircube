<?php
if(isset($comment['Comment']['status']) && $comment['Comment']['status'] == 0) {
	echo $this->Ircube->startBox(array('color' => 'green'));
	echo $this->Ircube->startBoxContent();
	__('Votre commentaire a été enregistré, il doit être validé pour être visible');
	echo $this->Ircube->endBox();
} 
else {
	echo $this->element('comment', array('comment' => am($comment['Comment'], array('Author' => $comment['Author'])), 'i' => $comment[$comment['Comment']['model']]['comment_count']));
}
?>