<h1><?php echo __('Tableau de bord : ', true) . $AuthUser['username']; ?></h1>

<div id="avatar">
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
?>
</ul>