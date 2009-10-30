<?php
echo $javascript->link('http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js', false);
echo $html->css(array('hot-sneaks/jquery-ui-1.7.2.custom'), null, array('inline' => false));
?>
<script type="text/javascript">
$(function() {
	/* TODO : Design ? */
	function swapImages(n, old) {
		var avatar = n.find('img');
		var avatar_id = avatar.attr('alt');
		var avatar_src = avatar.attr('src');
		var old_avatar = old.find('img');
		var old_avatar_id = old_avatar.attr('alt');
		var old_avatar_src = old_avatar.attr('src');
		
		old_avatar.attr('src', '/img/ajax-loader-big.gif');
		avatar.attr('src', '/img/ajax-loader-big.gif');
		
		$.post("<?php echo Router::url(array('controller' => 'user_pictures', 'action' => 'avatarify')); ?>", {id : avatar_id}, function(data) {
			$('#dialog > p').html(data);
			/* swap images */
			avatar.attr('alt', old_avatar_id);
			avatar.attr('src', old_avatar_src);
			old_avatar.attr('alt', avatar_id);
			old_avatar.attr('src', avatar_src);
		});
	}
	
	/* Remove current avatar */
	$('div.avatar').click(function() {
		var src = '<?php echo $this->Ircube->avatar($userProfile); ?>';
		var old_avatar = $(this).find('img');
		$(this).effect('highlight', {}, 2000);
		old_avatar.attr('src', '/img/ajax-loader-big.gif');
		$.get('<?php echo Router::url(array('controller' => 'user_pictures', 'action' => 'unavatarify')); ?>', function() {
			old_avatar.load().attr("src", src + '?nocache=' + (new Date()).getTime());
		});
	});
	
	
	$('#gallery > div.thumbnail a').click(function() {
		$(this).parents('div.thumbnail').effect('highlight', {}, 2000);
		$('div.avatar, div.gravatar').effect('highlight', {}, 2000);
		swapImages($(this).parents('div.thumbnail'), $('div.avatar'));
		return false;
	});
});
</script>
<div id="dialog" title="Basic dialog">
	<p></p>
</div>
<h1><?php __('Votre avatar :'); ?></h1>
<?php
/* TODO : javascript drag & drop */
	echo $ircube->thumbnailWrap($this->Html->image($this->Ircube->avatar($userProfile['UserProfile']['username'])), array('class' => 'thumbnail avatar'));
?>
<div class="clear"></div>
<h1><?php __('Choisissez votre avatar'); ?></h1>
<div id="gallery">
<?php
foreach($userProfile['Attachment'] as $i) {
	echo $ircube->thumbnailWrap($html->image($medium->webroot('filter' . DS . 's' . DS . $i['dirname'] . DS . $i['basename']), array('alt' => $i['id'], 'url' => array('action' => 'avatarify', 'id' => $i['id']))));
}
?>
</div>