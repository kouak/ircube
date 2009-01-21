<?php
$javascript->link('jquery/jquery.lightbox', false);
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
});
</script>
<h1><?php echo __('Gallery de ', true) . $userProfile['username']; ?></h1>
<div id="gallery">
<?php
foreach($picture as $i) {
	echo $html->link($html->image('upload' . DS . 'thmb' . DS . $i['filename']),
					$html->webroot(IMAGES_URL . DS . 'upload' . DS . $i['filename']),
					array('escape' => false,)
					);
}
?>
</div>