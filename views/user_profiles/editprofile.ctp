<?php
$javascript->link(array('jquery/jquery.fcbkcomplete'), false);
$html->css(array('jquery/fcbkcomplete'), null, array(), false);
?>
<script type="text/javascript">
/*
$(function() {
	$("#channels").fcbkcomplete({
		'json_url': "<?php echo Router::url(array('controller' => 'channels', 'action' => 'autoComplete')); ?>",
		'cache': false,
		'newel': false,
		'firstselected': true,
		'complete_text': "Indiquez les salons que vous fréquentez"
	});
});
*/
</script>
<h1>Modifier mon profil</h1>
<?php
echo $this->UniForm->create('UserProfile', array('action' => 'editprofile',));
echo $this->UniForm->input('UserProfile.sex', array('label' => __('Sexe', true), 'options' => array('f' => __('Femme', true), 'm' => __('Homme', true), 'u' => __('Inconnu', true)), 'default' => 'u'));
echo $this->UniForm->input('UserProfile.birthday', array('label' => __('Anniversaire', true), 'dateFormat' => 'DMY', 'minYear' => '1920', 'maxYear' => '2008', 'style' => 'width: auto; float: none;'));
echo $this->UniForm->input('UserProfile.url', array('label' => __('Site internet', true)));
/* 
TODO : integrates on ChannelProfiles pages (github follow style)
echo $this->UniForm->input('Channel', array('options' => Set::combine($this->data['Channel'], '/id', '/channel'), 'id' => 'channels', 'label' => __('Salons favoris', true)));
*/
echo $this->UniForm->submit();
echo $this->UniForm->end();
?>