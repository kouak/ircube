<?php
$javascript->link('swfupload/swfupload', false);
$javascript->link('user_pictures/add', false);
?>
<script type="text/javascript">
var swfu;
$(function() {
	swfu = new SWFUpload({
		upload_url : '<?php echo $html->url(array('action' => 'upload', )); ?>',
		flash_url : '<?php echo $html->url(DS . JS_URL . DS . 'swfupload' . DS . 'swfupload.swf'); ?>',
		file_size_limit : "20480",
		post_params: {"PHPSESSID" : "<?php echo $session->id(); ?>"},
		

		// File Upload Settings
		file_size_limit : "2 MB",	// 2MB
		file_types : "*",
		file_types_description : "JPG Images",
		file_upload_limit : "0",

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
		button_placeholder_id : "spanButtonPlaceholder",
		button_width: 180,
		button_height: 18,
		button_text : '<span class="button">Select Images <span class="buttonSmall">(2 MB Max)</span></span>',
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
});
</script>
	<h2>Application Demo</h2>
	<p>This demo shows how SWFUpload can behave like an AJAX application.  Images are uploaded by SWFUpload then some JavaScript is used to display the thumbnails without reloading the page.</p>
	<form>
		<div style="display: inline; border: solid 1px #7FAAFF; background-color: #C5D9FF; padding: 2px;">
			<span id="spanButtonPlaceholder"></span>
		</div>
	</form>
		<div id="divFileProgressContainer" style="height: 75px;"></div>
	<div id="thumbnails"></div>