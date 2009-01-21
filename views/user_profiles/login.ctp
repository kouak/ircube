<?php
    echo $form->create('UserProfile', array('action' => 'login'));
    echo $form->input('UserProfile.username');
    echo $form->input('UserProfile.password', array('value' => ''));
	if(isset($createprofile)) {
		echo $html->link(__('Vous avez déja un compte Z ? Créez votre profil.', true), array('controller' => 'user_profiles', 'action' => 'create_profile'));
	}
	elseif(isset($resynchprofile)) {
		echo $html->link(__('Vous aviez déja un profil sur le site dans le passé ? Retrouvez-le.', true), array('controller' => 'user_profiles', 'action' => 'resynch_profile'));
	}
    echo $form->end('Login');
?>