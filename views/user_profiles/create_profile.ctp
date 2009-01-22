<h1><?php __('Créez votre profil à partir de votre compte Z'); ?></h1>
<h3><?php __('Votre compte Z :'); ?></h3>
<?php
    echo $form->create('UserProfile', array('action' => 'create_profile'));
	echo $form->input('User.username');
	echo $form->input('User.password', array('value' => ''));
?>
<h3><?php __('Quelques informations pour compléter votre fiche :'); ?></h3>
<?php
	echo $form->input('UserProfile.url');
	echo $form->input('UserProfile.birthday');
	echo $form->input('UserProfile.sexe', array('options' => array('f' => __('Femme', true), 'm' => __('Homme', true), 'u' => __('Inconnu', true)), 'default' => 'u'));
	echo $form->end(__('Ok', true));
?>