<?php
?>
<h1><?php echo __('Profil de ', true) . $userProfiles['UserProfile']['username']; ?></h1>

<div class="avatar">
	<?php
//		if($userProfiles['UserProfile']['avatar_id'] == 0) { /* Use gravatar */
		if(!file_exists(IMAGES . DS . 'upload' . DS . 'avatar' . DS . ($avatar = $userProfiles['UserProfile']['username'] . '.png'))) {
			echo $gravatar->image('kouak@ircube.org');
		} else {
			echo $html->image($html->webroot(IMAGES_URL . DS . 'upload' . DS . 'avatar' . DS . $avatar));
		}
	?>
</div>
<div class="clear"></div>
<?php
foreach($grav as $mail) {
	echo $gravatar->image($mail);
}
?>