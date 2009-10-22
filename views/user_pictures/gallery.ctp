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
<h1><?php echo __('Gallery de ', true) . $userProfile['UserProfile']['username']; ?></h1>
	<?php
	if(!empty($userProfile['Avatar'])) {
		$content = $ircube->image($medium->webroot('filter' . DS . 's' . DS . $userProfile['Avatar']['dirname'] . DS . $userProfile['Avatar']['basename']), array('alt' => $userProfile['UserProfile']['username']));
	} else {
		$content = $ircube->thumbnailCenterWrap($gravatar->image($userProfile['UserProfile']['mail']));
	}
	echo $this->element('ircube-box', array('options' => array('id' => 'avatar', 'span' => 'span-6', 'color' => 'blue', 'header' => 'h3'), 'title' => sprintf(__('Avatar de %s', true), $userProfile['UserProfile']['username']), 'content' => $content));
	?>
</div>
<div id="gallery">
<?php
foreach($userProfile['Attachment'] as $i) {
	echo $ircube->thumbnailWrap($html->link($html->image($medium->webroot('filter' . DS . 's' . DS . $i['dirname'] . DS . $i['basename']), array('alt' => $i['id'])),
					$medium->webroot('filter' . DS . 'xl' . DS .$i['dirname'] . DS . $i['basename']),
					array('escape' => false,)
					));
}
?>
</div>