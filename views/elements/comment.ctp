<li id="#comment-<?php echo $i?>">
<div class="ircube-box">
	<div class="box orange noheader">
		<div class="comment-number">
			<span class="permlink"><a name="comment-<?php echo $i; ?>" href="#comment-<?php echo $i; ?>" title="Lien vers ce commentaire">#<?php echo $i; ?></a></span>
		</div>
		<div class="avatar">
			<?php echo $gravatar->image($comment['Author']['mail']); ?>
		</div>
		<div class="comment">
			<cite class="meta"> 
					<span class="author">
						<?php echo $profileHelper->link($comment['Author']['username'], $comment['Author']); ?>
					</span> 
					<span class="date"><?php echo $time->niceShort($comment['created']); ?></span> 
			</cite>
			<p class="comment-inside"><?php echo $comment['content']; ?></p>
		</div>
	</div>
</div>
</li>