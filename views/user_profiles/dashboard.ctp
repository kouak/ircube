<?php
$javascript->link(array('chat'), false);
$html->css(array('pages/home'), null, array(), false);

$homeChans = array(
	/* 8 Maximum, sinon layout foiré */
	array('name' => 'IRCube', 'checked' => true, 'users' => 39),
	array('name' => 'Poudlard', 'checked' => false, 'users' => 20),
	array('name' => 'Aide', 'checked' => true, 'users' => 13),
	array('name' => 'IRCube', 'checked' => true, 'users' => 39),
	array('name' => 'CoderZ', 'checked' => false, 'users' => 20),
	array('name' => 'Charme', 'checked' => true, 'users' => 13),
	array('name' => 'IRCube', 'checked' => true, 'users' => 39),
	array('name' => 'Poudlard', 'checked' => false, 'users' => 20),
	);

if(!file_exists(IMAGES . DS . 'upload' . DS . 'avatar' . DS . ($avatar = low($AuthUser['username']) . '.png'))) {
	$content = $gravatar->image($AuthUser['mail']);
} else {
	$content = $html->image($html->webroot(IMAGES_URL . DS . 'upload' . DS . 'avatar' . DS . $avatar));
}
echo $this->element('ircube-box', array('options' => array('id' => 'avatar', 'span' => 'span-6', 'color' => 'blue', 'header' => 'h3'), 'title' => sprintf(__('Bienvenue %s !', true), $AuthUser['username']), 'content' => $ircube->thumbnailCenterWrap($content)));

$content = $uniForm->create(null, array('url' => false, 'type' => 'get', 'id' => 'chatform', 'action' => false, 'class' => 'chatform')) . "\n";
$content .= $uniForm->input('Pseudo', array('type' => 'text', 'length' => 10, 'maxLength' => 20)) . "\n";
$content .= $uniForm->fieldset(array('blockLabels' => true)) . "\n";
$content .= '
			<div class="ctrlHolder">
				<p class="label">Salons</p>
				<div class="multiField">
';
foreach($homeChans as $chan) {
	$checked = ($chan['checked'] === true) ? 'checked' : '';
	$content .= <<<EOF
							<div class="chans"><label for=Salons${chan['name']}" class="inlineLabel"><input type="checkbox" name="Salons[]" $checked value="${chan['name']}" id="Salons${chan['name']}" />${chan['name']} ({$chan['users']})</label></div>
EOF;
}
$content .= '
				</div>
			</div>
';
$content .= $uniForm->submit(__('Tchattez !', true));
$content .= $uniForm->end();
echo $this->element('ircube-box', array('options' => array('color' => 'orange', 'id' => 'chatform', 'span' => 'span-10 push-1 last'), 'title' => 'Tchattez sur IRCube !', 'content' => $content));

?>
<div class="clear"></div>
<?php
echo $this->element('news/latest', array('span' => 'span-10 last', 'class' => 'orange', 'latestNews' => $latestNews));
?>
<div class="clear"></div>
<?php
$content = '<ul>
';
$content .= '<li>' . $html->link(__('Voir ma gallerie', true), array('controller' => 'user_pictures', 'action' => 'gallery', 'username' => $AuthUser['username'])) . '</li>';
$content .= '<li>' . $html->link(__('Modifier ma gallerie', true), array('controller' => 'user_pictures', 'action' => 'edit')) . '</li>';
$content .= '<li>' . $html->link(__('Voir ma fiche', true), array('controller' => 'user_profiles', 'action' => 'view', 'username' => $AuthUser['username'])) . '</li>';
$content .= '<li>' . $html->link(__('Modifier ma fiche', true), array('controller' => 'user_profiles', 'action' => 'edit')) . '</li>';
$content .= '<li>' . $html->link(__('Modifier mon avatar', true), array('controller' => 'user_pictures', 'action' => 'avatar')) . '</li>';
$content .= '</ul>';
echo $this->element('ircube-box', array('options' => array('span' => 'span-8 last', 'color' => 'green'), 'content' => $content));
?>