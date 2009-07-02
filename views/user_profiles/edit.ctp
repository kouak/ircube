<h1>Modifier mon profil</h1>
<?php
echo $uniForm->create('UserProfile', array('url' => array('controller' => 'user_profiles', 'action' => 'edit', 'id' => false)));
echo $uniForm->input('UserProfile.url');
echo $uniForm->input('UserProfile.birthday', array('dateFormat' => 'DMY', 'minYear' => '1920', 'maxYear' => '2008'));
echo $uniForm->input('UserProfile.sex', array('options' => array('f' => __('Femme', true), 'm' => __('Homme', true), 'u' => __('Inconnu', true)), 'default' => 'u'));
echo $uniForm->submit();
echo $uniForm->end();
?>