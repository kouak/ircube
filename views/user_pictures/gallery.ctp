<?php
$javascript->link('jquery/jquery.lightbox', false);
$html->css(array('jquery.lightbox'), null, array('inline' => false));
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
<h1><?php echo $this->Ircube->link(array('UserProfile' => $userProfile['UserProfile'])); ?></h1>
<div id="avatar" class="span-5">
	<?php
		echo $this->Ircube->thumbnailWrap($this->Html->image($this->Ircube->avatar($userProfile['UserProfile'])));
	?>
</div>
<div class="clear"></div>
<div id="gallery">
<?php
foreach($userProfile['Attachment'] as $i) {
	echo 
		$ircube->thumbnailWrap(
			$html->link(
				$html->image(
					$medium->webroot('filter' . DS . 's' . DS . $i['dirname'] . DS . $i['basename']),
					array('alt' => $i['id'])
				),
				$medium->webroot('filter' . DS . 'xl' . DS .$i['dirname'] . DS . $i['basename']),
				array('escape' => false,)
			)
		);
}
?>
</div>