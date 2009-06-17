<?php
if(!empty($user_profiles)) {
	foreach($user_profiles as $up) {
		echo $up['UserProfile']['username'].'|'.$up['UserProfile']['id']."\n";
	}
}
else {
	__('Pas de résultat');
}
?>