<?php
$javascript->link('swfupload/swfupload', false);
$javascript->link('user_pictures/add', false);
$html->css(array('swfupload'), null, array(), false);
?>
<script type="text/javascript">
var swfu;
$(function() {
	
	swfu = new SWFUpload({
		upload_url : '<?php echo $html->url(array('action' => 'upload', )); ?>',
		flash_url : '<?php echo $html->url(DS . JS_URL . DS . 'swfupload' . DS . 'swfupload.swf'); ?>',
		post_params: {"PHPSESSID" : "<?php echo $session->id(); ?>"},
		

		// File Upload Settings
		file_size_limit : "2 MB",	// 2MB
		file_types : "*.jpeg;*.png;*.jpg;*.gif",
		file_types_description : "Images",
		file_upload_limit : 0,
		file_queue_limit : 2,

		// Event Handler Settings - these functions as defined in Handlers.js
		//  The handlers are not part of SWFUpload but are part of my website and control how
		//  my website reacts to the SWFUpload events.
		file_queue_error_handler : fileQueueError,
		file_dialog_complete_handler : fileDialogComplete,
		upload_progress_handler : uploadProgress,
		upload_error_handler : uploadError,
		upload_success_handler : uploadSuccess,
		upload_complete_handler : uploadComplete,

		// Button Settings
		button_placeholder_id : "divButtonPlaceholder",
		button_width: 180,
		button_height: 30,
		button_text : '<span class="button"><?php __('Ajoutez une image.'); ?> <span class="buttonSmall">(2 MB Max)</span></span>',
		button_text_style : '.button { font-family: Helvetica, Arial, sans-serif; font-size: 12pt; } .buttonSmall { font-size: 10pt; }',
		button_text_top_padding: 0,
		button_text_left_padding: 18,
		button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
		button_cursor: SWFUpload.CURSOR.HAND,
		

		custom_settings : {
			upload_target : "divFileProgressContainer"
		},
		
		// Debug Settings
		debug: true,
		
	});
	
	loadDelete();

});

function loadDelete() {
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
}
</script>
	<h1>Modifiez votre gallerie !</h1>
	<form>
			<div id="divButtonPlaceholder" style="border: solid 1px #7FAAFF; background-color: #C5D9FF; padding: 2px;"></div>
	</form>
		<div id="divFileProgressContainer" style="height: 75px;"></div>
	<div class="clear"></div>
	<div id="thumbnails">
	<?php
		if(empty($picture)) {
			__('Oops ! Il n\'y a pas encore d\'image dans votre gallerie. Dépêchez vous d\'en ajouter !');
		} else {
			foreach($picture as $pic) {
				echo $ircube->image($html->webroot(IMAGES_URL . DS . 'upload' . DS . 'thmb' . DS . $pic['filename']), array('alt' => $pic['id']));
			}
		}
	?>
	</div>