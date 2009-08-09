<?php
$html->css(array('pages/home', 'ircube-boxes'), null, array(), false);
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
<div id="whatisircube" class="ircube-box span-10 push-1">
				<h1>C'est quoi IRCube ?</h1>
				<div class="box">
					<p class="largest">IRCube est un réseau de discussion francophone agréable et sans prise de tête.</p>
				</div>
</div>
<div id="chatform" class="ircube-box span-10 push-1 last">
	<h1 class="orange">Tchattez sur IRCube !</h1>
	<div class="box orange">
		<?php 
		echo $uniForm->create(null, array('url' => false, 'type' => 'get', 'id' => 'chatform', 'action' => false, 'class' => 'chatform'));
		echo $uniForm->input('Pseudo', array('type' => 'text', 'length' => 10, 'maxLength' => 20));
		echo $uniForm->fieldset(array('blockLabels' => true));
		?>
			<div class="ctrlHolder">
				<p class="label">Salons</p>
				<div class="multiField">
					<?php foreach($homeChans as $chan) {
						$checked = ($chan['checked'] === true) ? 'checked' : '';
						echo <<<EOF
							<div class="chans"><label for=Salons${chan['name']}" class="inlineLabel"><input type="checkbox" name="Salons[]" $checked value="${chan['name']}" id="Salons${chan['name']}" />${chan['name']} ({$chan['users']})</label></div>
EOF;
					}
					?>
				</div>
			</div>
		<?php
		echo $uniForm->submit(__('Tchattez !', true));
		echo $uniForm->end();
		?>
	</div>
</div>
<div class="clear"></div>
<?php
echo $this->element('news/latest', array('span' => 'span-10 push-1', 'class' => 'blue', 'latestNews' => $latestNews));
?>
<div id="wantmore" class="span-2 last">
	<p>Vous en voulez plus ?</p>
</div>