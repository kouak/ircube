<h1><?php echo __('Profil de ', true) . $userProfiles['UserProfile']['username']; ?></h1>
<h2>Avatar</h2>
<div class="avatar">
	<?php
//		if($userProfiles['UserProfile']['avatar_id'] == 0) { /* Use gravatar */
		if(!file_exists(IMAGES . DS . 'upload' . DS . 'avatar' . DS . ($avatar = low($userProfiles['UserProfile']['username']) . '.png'))) {
			echo $gravatar->image($userProfiles['UserProfile']['mail']);
		} else {
			echo $html->image($html->webroot(IMAGES_URL . DS . 'upload' . DS . 'avatar' . DS . $avatar));
		}
	?>
</div>
<div class="clear"></div>
<h2>Informations</h2>
<?php
switch($userProfiles['UserProfile']['sex']) {
	case 'f':
		$userProfiles['UserProfile']['sex'] = __('Femme', true);
		break;
	case 'm':
		$userProfiles['UserProfile']['sex'] = __('Homme', true);
		break;
	default:
		$userProfiles['UserProfile']['sex'] = __('Inconnu', true);
}
?>

