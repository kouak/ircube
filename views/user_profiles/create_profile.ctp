<h1><?php __('Créez votre profil à partir de votre compte Z'); ?></h1>
<?php
    echo $uniForm->create('UserProfile', array('action' => 'create_profile', 'fieldset' => __('Votre compte Z', true)));
	echo $uniForm->input('User.username', array('label' => __('Username', true)));
	echo $uniForm->input('User.password', array('value' => '', 'label' => __('Mot de passe', true)));
	echo $uniForm->fieldset(__('Quelques informations pour compléter votre fiche', true));
	echo $uniForm->input('UserProfile.url', array('label' => __('Site perso', true)));
	echo $uniForm->input('UserProfile.birthday', array('label' => __('Anniversaire', true),'dateFormat' => 'DMY', 'minYear' => '1920', 'maxYear' => '2008', 'style' => 'width: auto;'));
	echo $uniForm->input('UserProfile.sex', array('label' => __('Sexe', true), 'options' => array('f' => __('Femme', true), 'm' => __('Homme', true), 'u' => __('Inconnu', true)), 'default' => 'u'));
	echo $uniForm->end(__('Soumettre', true));
?>