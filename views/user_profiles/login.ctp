<?php
    echo $uniForm->create('UserProfile', array('action' => 'login', 'fieldset' => __('Connectez vous', true)));
    echo $uniForm->input('UserProfile.username');
    echo $uniForm->input('UserProfile.password', array('value' => '', 'label' => 'Mot de passe'));
	if(isset($createprofile)) {
		echo $html->link(__('Vous avez déja un compte Z ? Créez votre profil.', true), array('controller' => 'user_profiles', 'action' => 'create_profile'));
	}
	elseif(isset($resynchprofile)) {
		echo $html->link(__('Vous aviez déja un profil sur le site dans le passé ? Retrouvez-le.', true), array('controller' => 'user_profiles', 'action' => 'resynch_profile'));
	}
    echo $uniForm->end('Login');
?>