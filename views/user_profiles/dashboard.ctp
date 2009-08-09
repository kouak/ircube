<h1><?php echo sprintf(__('Bienvenue %s !', true), $AuthUser['username']); ?></h1>
<?php
echo $this->element('news/latest', array('span' => 'span-10 push-1', 'class' => 'orange', 'latestNews' => $latestNews));
?>
<div id="avatar" class="span-6 ircube-box">
	<h3 class="blue">Votre avatar</h3>
	<div class="box blue">
		<?php
	//		if($userProfiles['UserProfile']['avatar_id'] == 0) { /* Use gravatar */
			if(!file_exists(IMAGES . DS . 'upload' . DS . 'avatar' . DS . ($avatar = low($AuthUser['username']) . '.png'))) {
				$gr = true;
				echo $gravatar->image($AuthUser['mail']);
			} else {
				echo $html->image($html->webroot(IMAGES_URL . DS . 'upload' . DS . 'avatar' . DS . $avatar));
			}
		?>
	</div>
</div>
<?php
if(isset($gr) && $gr === true) {
	echo __('Cet avatar a été généré avec ', true) . $html->link('Gravatar', 'http://www.gravatar.com/');
}
?>
<div class="clear"></div>
<ul>
<?php
echo '<li>' . $html->link(__('Voir ma gallerie', true), array('controller' => 'user_pictures', 'action' => 'gallery', 'username' => $AuthUser['username'])) . '</li>';
echo '<li>' . $html->link(__('Modifier ma gallerie', true), array('controller' => 'user_pictures', 'action' => 'edit')) . '</li>';
echo '<li>' . $html->link(__('Voir ma fiche', true), array('controller' => 'user_profiles', 'action' => 'view', 'username' => $AuthUser['username'])) . '</li>';
echo '<li>' . $html->link(__('Modifier ma fiche', true), array('controller' => 'user_profiles', 'action' => 'edit')) . '</li>';
echo '<li>' . $html->link(__('Modifier mon avatar', true), array('controller' => 'user_pictures', 'action' => 'avatar')) . '</li>';
?>
</ul>