<?php
$javascript->link('jquery/jquery.lightbox', false);
$javascript->link('jquery/jquery.captify', false);
$html->css(array('jquery.captify'), null, array(), false);
$html->css(array('jquery.lightbox'), null, array(), false);
?>
<script type="text/javascript">
$(function() {
	$('#gallery a').lightBox({
		imageLoading: '<?php echo $html->webroot(IMAGES_URL . DS . 'lightbox' . DS . 'ico-loading.gif'); ?>',
		imageBtnClose: '<?php echo $html->webroot(IMAGES_URL . DS . 'lightbox' . DS . 'btn-close.gif'); ?>',
		imageBtnPrev: '<?php echo $html->webroot(IMAGES_URL . DS . 'lightbox' . DS . 'btn-prev.gif'); ?>',
		imageBtnNext: '<?php echo $html->webroot(IMAGES_URL . DS . 'lightbox' . DS . 'btn-next.gif'); ?>',
		imageBlank : '<?php echo $html->webroot(IMAGES_URL . DS . 'lightbox' . DS . 'blank.gif'); ?>',
		containerResizeSpeed: 200,
		txtOf: '<?php __('sur'); ?>',
		overlayOpacity: 0.6,
	});
	
	$('#gallery img').captify({
		// speed of the mouseover effect
		speedOver: 150,
		// speed of the mouseout effect
		speedOut: 200,
		// how long to delay the hiding of the caption after mouseout (ms)
		hideDelay: 100,
		// 'fade' or 'slide'
		animation: 'fade',	  	
		// text/html to be placed at the beginning of every caption
		prefix: '',	
		// the name of the CSS class to apply to the caption box
		className: 'captify'
	});
	
});
</script>
<h1><?php echo __('Gallery de ', true) . $userProfile['username']; ?></h1>
<div id="gallery">
<?php
foreach($picture as $i) {
	echo $html->link($html->image('upload' . DS . 'thmb' . DS . $i['filename'], array('alt' => $i['id'])),
					$html->webroot(IMAGES_URL . DS . 'upload' . DS . $i['filename']),
					array('escape' => false,)
					);
}
?>
</div>