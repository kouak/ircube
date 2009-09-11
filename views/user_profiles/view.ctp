<?php
echo $html->css(array('ircube-boxes'), null, array(), false);
?>
<div id="avatar" class="span-6 prepend-1 ircube-box">
	<h1 class="blue"><?php echo $userProfiles['UserProfile']['username']; ?></h1>
	<div class="box blue">
			<?php
		//		if($userProfiles['UserProfile']['avatar_id'] == 0) { /* Use gravatar */
				if(!file_exists(IMAGES . DS . 'upload' . DS . 'avatar' . DS . ($avatar = low($userProfiles['UserProfile']['username']) . '.png'))) {
					echo $gravatar->image($userProfiles['UserProfile']['mail']);
				} else {
					echo $html->image($html->webroot(IMAGES_URL . DS . 'upload' . DS . 'avatar' . DS . $avatar));
				}
			?>
	</div>
</div>
<div id="user-informations" class="span-12 prepend-2 ircube-box last">
	<h2 class="orange">Informations</h2>
	<div class="box orange">
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

		echo __('Sexe : ', true) . $userProfiles['UserProfile']['sex'] . '<br />';
		echo __('Url : ', true) . $userProfiles['UserProfile']['url'] . '<br />';
		echo __('Date de naissance : ', true) . $userProfiles['UserProfile']['birthday'] . '<br />';
		?>
	</div>
</div>
<div class="clear"></div>
<div id="user-informations" class="span-12 prepend-2 ircube-box last">
	<h2 class="orange">Salons fréquentés</h2>
	<div class="box orange">
		<ul>
			<?php
				foreach($userProfiles['Channel'] as $channel) {
					echo '<li>' . $html->link($channel['channel'], $ircube->channelProfileUrl($channel['channel'])) . '</li>';
				}
			?>
		</ul>
	</div>
</div>