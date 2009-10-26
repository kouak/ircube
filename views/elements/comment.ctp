<li id="#comment-<?php echo $i?>">	
<?php
App::import('Sanitize');
if(isset($comment['Comment'])) {
	$author = $comment['Author'];
	$comment = $comment['Comment'];
	$comment['Author'] = $author;
	unset($author);
}

$content = <<<EOF
		<div class="comment-number">
			<span class="permlink"><a name="comment-$i" href="#comment-$i" title="Lien vers ce commentaire">#</a></span>
		</div>
		<div class="avatar">
			
EOF;
$content .= $this->Html->image($this->Ircube->avatar($comment['Author']['username']));
$content .= '
		</div>
		<div class="comment">
			<cite class="meta"> 
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
?>
</li>