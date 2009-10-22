<li id="#comment-<?php echo $i?>">	
<?php
$content = <<<EOF
		<div class="comment-number">
			<span class="permlink"><a name="comment-$i" href="#comment-$i" title="Lien vers ce commentaire">#$i</a></span>
		</div>
		<div class="avatar">
			
EOF;
$content .= $html->image(Router::url(array('controller' => 'user_pictures', 'action' => 'avatar', 's', $comment['Author']['username'])));
$content .= '
		</div>
		<div class="comment">
			<cite class="meta"> 
					<span class="author">
						';
$content .= $profileHelper->link($comment['Author']['username'], $comment['Author']);
$content .= '
					</span> 
					<span class="date">' . $time->niceShort($comment['created']) . '</span> 
			</cite>
			<p class="comment-inside">' . $comment['content'] . '</p>
		</div>
';
?>
<?php
	$color = 'green';
	if($i % 2 == 0) {
		$color = 'orange';
	}
	echo $this->element('ircube-box', array('options' => array('header' => false, 'color' => $color), 'content' => $content));
?>
</li>