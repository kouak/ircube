<?php
$javascript->link(array('jquery/jquery.fcbkcomplete'), false);
$html->css(array('jquery/fcbkcomplete'), null, array(), false);
?>
<script type="text/javascript">
$(function() {
	$("#channels").fcbkcomplete({
		'json_url': "<?php echo Router::url(array('controller' => 'channels', 'action' => 'autoComplete')); ?>",
		'cache': false,
		'newel': false,
		'firstselected': true,
		'complete_text': "Indiquez les salons que vous fréquentez"
	});
});
</script>
<h1>Modifier mon profil</h1>
<?php
debug($this->data);
echo $uniForm->create(null, array('url' => array('controller' => 'user_profiles', 'action' => 'edit', 'id' => false)));
echo $uniForm->input('UserProfile.url');
echo $uniForm->input('UserProfile.birthday', array('dateFormat' => 'DMY', 'minYear' => '1920', 'maxYear' => '2008'));
echo $uniForm->input('UserProfile.sex', array('options' => array('f' => __('Femme', true), 'm' => __('Homme', true), 'u' => __('Inconnu', true)), 'default' => 'u'));
echo $uniForm->input('Channel', array('options' => Set::combine($this->data['Channel'], '/id', '/channel'), 'id' => 'channels', 'label' => __('Salons favoris', true)));
echo $uniForm->submit();
echo $uniForm->end();
?>