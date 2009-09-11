<?php
$html->css(array('pages/home'), null, array(), false);
$javascript->link(array('chat'), false);

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
?>
<div class="clear"></div>
<?php
echo $this->element('ircube-box', array('options' => array('span' => 'span-10 push-1', 'id' => 'whatisircube'), 'title' => 'C\'est quoi IRCube ?', 'content' => '<p class="largest">IRCube est un réseau de discussion francophone agréable et sans prise de tête.</p>'));

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
echo $this->element('news/latest', array('span' => 'span-10 push-1', 'class' => 'blue', 'latestNews' => $latestNews));
?>
<div id="wantmore" class="span-2 last">
	<p>Vous en voulez plus ?</p>
</div>