<?php
$html->css(array('dashboard/avatar'), null, array(), false);
?>
<script type="text/javascript">
$(function() {
	$('div#gravatar-avatar a').click(function() {
		var c = confirm('Ceci entrainera la suppression d\'un éventuel avatar généré à partir de votre gallerie ! Continuer ?');
		if(c) {
			$.get($(this).attr('href'), function() {
				$('#actual-avatar img').fadeOut('fast', function() {
					$(this).load(function() {
						$(this).fadeIn('fast');
					}).attr('src', $('#gravatar-avatar img').attr('src'));
				});
			});
		}
		return false;
	});
});
</script>
<h1>Votre avatar</h1>
<div id="actual-avatar">
	<h2>Votre avatar actuel</h2>
	<?php echo $ircube->thumbnailWrap($gravatar->ircube_avatar($userProfile['UserProfile'])); ?>
</div>
<div id="gravatar-avatar">
	<h2>Utiliser votre Gravatar</h2>
		<?php echo $ircube->thumbnailWrap($gravatar->image($userProfile['UserProfile']['mail'], array('url' => array('action' => 'use_gravatar'), 'id' => 'use_gravatar'))); ?>
</div>
<div id="gallery-avatar">
	<h2>Créer un avatar grace à votre gallerie</h2>
	<?php echo $ircube->thumbnailWrap($html->image('unknown.png', array('url' => array('action' => 'avatar_from_gallery')))); ?>
</div>