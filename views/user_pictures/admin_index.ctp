<script type="text/javascript">
$(function() {
	$('#thumbnails div.thumbnail').hover(function() {
		var id = $(this).find('img').attr('alt');
		$('<a href="#" id="delete-img" rel="3" style="position:absolute; top:5px; right:5px;"><img src="/img/delete.png" alt="Supprimez cette image" /></a>')
		.prependTo($(this))
		.click(function() {
			$('#delete-img img').attr('src', '/img/ajax-loader-tiny.gif');
			$('#delete-img').attr('id', 'loading-img');
			$.ajax({
				type: "POST",
				url: "<?php echo Router::url(array('controller' => 'user_pictures', 'action' => 'delete')); ?>",
				data: "id=" + id,
				dataType: "html", /* IMPORTANT */
				success: function(msg) {
					var i = parseInt(this.data.replace('id=', ''));
					/* Remove image ... */
					$('div.thumbnail img[alt=' + i + ']').parents('div.thumbnail').fadeOut('slow', function() {
						$(this).remove();
					});
				}
			});
			return false;
		});
	}, function() {
		var id = $(this).find('img').attr('alt');
		$('#delete-img').remove();
	});
});
</script>
<?php
$paginator->options(array('url' =>  $this->passedArgs));
/* Set modulus here */
$mod = 4;
?>
<h1><?php __('Dernières photos ajoutées'); ?></h1>
<div class="paging">
	<div class="pages">
<?php 
	echo $paginator->prev('<< ', array('class' => 'left'), '<< ', array('class'=>'disabled'));
	echo $paginator->numbers(array('modulus' => $mod, 'separator' => '', 'first' => 1, 'last' => 1));
	echo $paginator->next(' >>', array('class' => 'right'), ' >>', array('class'=>'disabled')); 
?>
	</div>
</div>
<div class="clear"></div>
<div id="thumbnails">
	<?php
	foreach($user_pictures as $i) {
		$UserPicture = $i['UserPicture'];
		echo $ircube->thumbnailWrap($html->image('upload' . DS . 'thmb' . DS . $UserPicture['filename'], array('alt' => $UserPicture['id'])));

	}
	?>
</div>
