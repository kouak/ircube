<h1>Modifier mon profil</h1>
<?php
echo $form->create('UserProfile', array('url' => array('controller' => 'user_profiles', 'action' => 'edit', 'id' => false)));
echo $form->input('UserProfile.url');
echo $form->input('UserProfile.birthday', array('dateFormat' => 'DMY', 'minYear' => '1920', 'maxYear' => '2008'));
echo $form->input('UserProfile.sex', array('options' => array('f' => __('Femme', true), 'm' => __('Homme', true), 'u' => __('Inconnu', true)), 'default' => 'u'));
echo $form->submit();
echo $form->end();
?>