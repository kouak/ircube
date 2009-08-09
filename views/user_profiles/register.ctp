<?php
echo $uniForm->create('UserProfile', array('action' => 'register'));
echo $uniForm->input('UserProfile.username');
echo $uniForm->input('UserProfile.tmp-password', array('value' => '', 'type' => 'password'));
echo $uniForm->input('UserProfile.password-confirm', array('value' => '', 'type' => 'password'));
echo $uniForm->input('UserProfile.mail');
echo $uniForm->submit();
echo $uniForm->end();
?>