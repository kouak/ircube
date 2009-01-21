<h1>Informations sur votre compte Z actuel :</h1>
<?php
    echo $form->create('UserProfile', array('action' => 'create_profile'));
	echo $form->input('User.username');
	echo $form->input('User.password', array('value' => ''));
?>
<h1>Informations sur votre profil :</h1>
<?php
	echo $form->input('UserProfile.url');
	echo $form->end(__('Ok', true));
?>