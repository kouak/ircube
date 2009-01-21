<h1>Informations sur votre compte Z actuel :</h1>
<?php
    echo $form->create('UserProfile', array('action' => 'resynch_profile'));
	echo $form->input('User.username');
	echo $form->input('User.password', array('value' => ''));
?>
<h1>Informations sur votre ancien profil :</h1>
<?php
	echo $form->input('UserProfile.username');
	echo $form->input('UserProfile.password', array('value' => ''));
	echo $form->end(__('Ok', true));
?>