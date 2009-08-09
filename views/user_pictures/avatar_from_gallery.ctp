<?php

?>
<script type="text/javascript">
$(function() {

});
</script>
<h1><?php echo __('Choisissez l\'image pour construire votre avatar', true); ?></h1>
<div id="gallery">
<?php
foreach($picture as $i) {
	echo $ircube->thumbnailWrap($html->image('upload' . DS . 'thmb' . DS . $i['filename'], array('alt' => $i['id'], 'url' => array('action' => 'avatarify', 'id' => $i['id']))));
}
?>
</div>