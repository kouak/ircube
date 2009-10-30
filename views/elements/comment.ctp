<li id="#comment-<?php echo $i?>">
<?php
App::import('Sanitize');
if(isset($comment['Comment'])) {
	$author = $comment['Author'];
	$comment = $comment['Comment'];
	$comment['Author'] = $author;
	unset($author);
}
/*
$content = <<<EOF
		<div class="avatar">
			
EOF;
$content .= $this->Html->image($this->Ircube->avatar($comment['Author']['username'], array('size' => 'xs')));
$content .= '
		</div>
		<div class="comment">
			<cite class="meta">
				<span class="perlink">
					';
$content .= $this->Html->link('#', array('controller' => 'comments', 'action' => 'view', $comment['id']));
$content .= '
				</span>
				<span class="author">
					';
$content .= $this->Ircube->link(array('UserProfile' => $comment['Author']));
$content .= '
				</span> 
				<span class="date">' . $this->Time->niceShort($comment['created']) . '</span> 
			</cite>
			<p class="comment-inside">' . $this->Bbcode->parse(Sanitize::html($comment['content'])) . '</p>
		</div>
';
?>
<?php
	$color = 'green';
	if($i % 2 == 0) {
		$color = 'orange';
	}
	echo $this->Ircube->startBox(array('header' => false, 'color' => $color));
	echo $this->Ircube->startBoxContent();
	echo $content;
	echo $this->Ircube->endBox();
*/
?>
	<ul class="meta">
		<li class="image"><?php echo $this->Html->image($this->Ircube->avatar($comment['Author']['username'], array('size' => 'xs'))); ?></li>
		<li class="author"><?php echo $this->Ircube->link(array('UserProfile' => $comment['Author'])); ?></li>
		<li class="date"><?php echo $this->Time->nice($comment['created']); ?></li>
	</ul>
	<div class="body"><?php echo $this->Bbcode->parse(Sanitize::html($comment['content'])); ?></div>
</li>