<?php
echo $this->element('filter_letters', array('filterLetter' => $filterLetters));
foreach($userProfiles as $username) {
	echo $html->link($username, array('controller' => 'user_profiles', 'action' => 'view', 'username' => $username)) .  '<br />';
}
?>