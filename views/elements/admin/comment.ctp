<?php
if(isset($comment['published']) && $comment['published'] == true) {
	$published = true;
}
else {
	$published = false;
}
?>
<script type="text/javascript">
$(document).ready(function() {
	$('#comment-<?php echo $comment['id']; ?> div.comment-number a.delete').click(function() {
		var c = confirm("Supprimer ce commentaire ?");
		if(c) {
			$(this).children('img').attr({src: "/img/ajax-loader-snake.gif", alt: "Loading", id: 'delete-loading'});
			var toDelete = $('li#comment-<?php echo $comment['id']; ?>');
			$.ajax({
				type: "GET",
				url: $(this).attr('href'),
				dataType: "html",
				success: function(msg){
					toDelete.slideUp("medium", function() {
						$(this).remove();
					});
				}
			});
		}
		return false;
	});
	/* Hide loader */
	$('#comment-<?php echo $comment['id']; ?> div.comment-number img#publish-loader').hide();
	<?php
	/* Handle command buttons */
	if($published === true) {
	?>
		$('#comment-<?php echo $comment['id']; ?> div.comment-number a.publish').hide();
	<?php
	}
	else {
	?>
		$('#comment-<?php echo $comment['id']; ?> div.comment-number a.unpublish').hide();
	<?php	
	}
	?>
	
	
	$('#comment-<?php echo $comment['id']; ?> div.comment-number a.publish').click(function() {
		$(this).hide();
		$('#comment-<?php echo $comment['id']; ?> div.comment-number img#publish-loader').show();
		$.ajax({
			type: "GET",
			url: $(this).attr('href'),
			dataType: "html",
			success: function(msg){
				$('#comment-<?php echo $comment['id']; ?>').removeClass('unpublished');
				$('#comment-<?php echo $comment['id']; ?> div.comment-number #publish-loader').hide();
				$('#comment-<?php echo $comment['id']; ?> div.comment-number a.unpublish').show();
			}
		});
		return false;
	});
	
	$('#comment-<?php echo $comment['id']; ?> div.comment-number a.unpublish').click(function() {
		$(this).hide();
		$('#comment-<?php echo $comment['id']; ?> div.comment-number img#publish-loader').show();
		$.ajax({
			type: "GET",
			url: $(this).attr('href'),
			dataType: "html",
			success: function(msg){
				$('#comment-<?php echo $comment['id']; ?>').addClass('unpublished');
				$('#comment-<?php echo $comment['id']; ?> div.comment-number #publish-loader').hide();
				$('#comment-<?php echo $comment['id']; ?> div.comment-number a.publish').show();
			}
		});
		return false;
	});
});
</script>
<li id="comment-<?php echo $comment['id']; ?>" <?php if($published === false) { echo "class=\"unpublished\""; }?>>
	<div class="comment-number">
		<span class="permlink">#<?php echo $comment['id']; ?></span>
		<?php
		/* Print both icons, handle them via jQuery */
		echo $html->link($html->image('refuse.png', array('alt' => __('Publier', true))),
					array('controller' => $this->controller, 'action' => 'publish', 'admin' => true, $comment['id']),
					array('escape' => false, 'class' => 'publish')
					);
		echo $html->link($html->image('accept.png', array('alt' => __('Masquer', true))),
						array('controller' => $this->controller, 'action' => 'admin_unpublish', 'admin' => true, $comment['id']),
						array('escape' => false, 'class' => 'unpublish')
						);
		
		echo $html->image('ajax-loader-snake.gif', array('alt' => 'Loading', 'id' => 'publish-loader'));
		/*
		Todo : edit comments
		echo $html->link($html->image('edit.png', array('alt' => __('Editer', true))),
						array('controller' => $this->controller, 'action' => 'admin_edit', $comment['id']),
						array('escape' => false,)
						);
		*/
		echo $html->link($html->image('delete.png', array('alt' => __('Supprimer', true))),
						array('controller' => $this->controller, 'action' => 'admin_delete', $comment['id']),
						array('escape' => false, 'class' => 'delete')
						);
		?>
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
	<div class="clear" />
</li>