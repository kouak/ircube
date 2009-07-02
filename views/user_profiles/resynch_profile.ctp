<?php
    echo $uniForm->create('UserProfile', array('action' => 'resynch_profile', 'fieldset' => __('Informations sur votre compte Z actuel', true)));
	echo $uniForm->input('User.username');
	echo $uniForm->input('User.password', array('value' => '', 'label' => __('Mot de passe', true)));
	echo $uniForm->fieldset(__('Informations sur votre ancien profil', true));
	echo $uniForm->input('UserProfile.username');
	echo $uniForm->input('UserProfile.password', array('value' => '', 'label' => __('Mot de passe', true)));
	echo $uniForm->end(__('Ok', true));
?>