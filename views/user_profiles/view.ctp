<?php
echo $html->css(array('ircube-boxes', 'comments'), null, array('inline' => false));
?>
<h1><?php echo $this->Ircube->link(array('UserProfile' => $userProfile['UserProfile'])); ?></h1>
<div id="avatar" class="span-5">
	<?php
		$seeMore = '';
		if($userProfile['UserProfile']['attachment_count'] > 0) {
			$seeMore = '<div class="clear"></div>' . 
			$this->Html->link('Album (' . $userProfile['UserProfile']['attachment_count'] . __n(' photo', ' photos', $userProfile['UserProfile']['attachment_count'], true) . ')',
							  array('controller' => 'user_pictures', 'action' => 'gallery', $userProfile['UserProfile']['username']));
		}
		echo $this->Ircube->thumbnailWrap($this->Html->image($this->Ircube->avatar($userProfile['UserProfile'])) . $seeMore);
	?>
</div>
<div id="user-informations" class="span-12 prepend-2 last box">
		<?php
		if(isset($canEdit)) {
		?>
		<span style="float: right;">
			<?php
				echo $this->Html->link(__('Editer', true), array('action' => 'editprofile'));
			?>
		</span>
		<?php
		}
		switch($userProfile['UserProfile']['sex']) {
			case 'f':
				$userProfile['UserProfile']['sex'] = __('Femme', true);
				break;
			case 'm':
				$userProfile['UserProfile']['sex'] = __('Homme', true);
				break;
			default:
				$userProfile['UserProfile']['sex'] = __('Inconnu', true);
		}
		?>
	<table>
		<tr>
			<td><?php __('Sexe :'); ?></td>
			<td><?php echo $userProfile['UserProfile']['sex']; ?></td>
		</tr>
		<tr>
			<td><?php __('Site :'); ?></td>
			<td><?php echo $this->Html->link($userProfile['UserProfile']['url']); ?></td>
		</tr>
		<tr>
			<td><?php __('Date de naissance :'); ?></td>
			<td><?php echo $userProfile['UserProfile']['birthday']; ?></td>
		</tr>
		<tr>
			<td><?php __('Membre depuis :'); ?></td>
			<td><?php echo $this->Time->timeAgoInWords($userProfile['User']['created']); ?></td>
		</tr>
		<tr>
			<td><?php __('Dernière visite :'); ?></td>
			<td><?php 
			if($this->Time->wasWithinLast('5 minutes', $userProfile['UserProfile']['lastseen'])) {
				echo '<strong>' . __('En ligne', true) . '</strong>';
			} else {
				echo $this->Time->timeAgoInWords($userProfile['UserProfile']['lastseen']);
			}
			?></td>
		</tr>
	</table>
</div>
<div class="clear"></div>
<?php
echo $this->Ircube->startBox(array('span' => 'span-6', 'color' => 'blue', 'header' => 'h3'));
echo $this->Ircube->boxTitle(__('Ses amis', true));
echo $this->Ircube->startBoxContent();
for($i=0;$i<4;$i++) {
	echo $this->Html->image($this->Ircube->avatar($userProfile['UserProfile'], array('size' => 'xs')));
}
echo $this->Ircube->endBox();
?>

<div id="user-informations" class="span-12 prepend-2 ircube-box last">
	<h2 class="orange">Salons fréquentés</h2>
	<div class="box orange">
		<ul>
			<?php
				foreach($userProfile['Channel'] as $channel) {
					echo '<li>' . $html->link($channel['channel'], $ircube->channelProfileUrl($channel['channel'])) . '</li>';
				}
			?>
		</ul>
	</div>
</div>
<div class="clear"></div>
<a name="comments"></a><h2><?php printf(__('Commentaires (%d)', true), $userProfile['UserProfile']['comment_count']); ?></h2>
<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function() {
	$('div#comments > ol#commentlist').load('<?php echo Router::url(array('controller' => 'comments', 'action' => 'display', 'user_profile', $userProfile['UserProfile']['id'])); ?>');
});
</script>
<div id="comments">
	<div id="loader" style="width:100%;text-align:center;" class="clear"> 
	    <?php echo $this->Html->image('ajax-loader.gif'); ?> 
	</div>
	<ol class="comments" id="commentlist">
	</ol>
</div>
<div class="clear"></div>
<?php
if(isset($AuthUser['id']) && $AuthUser['id'] > 0) {
?>
<div id="comment_form">
<?php
echo $this->element('comment_form', array('model_id' => $userProfile['UserProfile']['id'], 'model' => 'UserProfile'));
?>
</div>
<?php
}
else {
?>
<h2>Laisser un commentaire</h2>
<p>Vous devez être identifiés pour laisser un commentaire</p>
<?php
}
?>

<div class="clear"></div>