<?php
echo $html->css(array('ircube-boxes', 'comments'), null, array(), false);
?>
<h1><?php echo $this->Ircube->link(array('UserProfile' => $userProfiles['UserProfile'])); ?></h1>
<div id="avatar" class="span-5">
	<?php
		echo $this->Ircube->thumbnailWrap($this->Html->image($this->Ircube->avatar($userProfiles['UserProfile'])));
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
		switch($userProfiles['UserProfile']['sex']) {
			case 'f':
				$userProfiles['UserProfile']['sex'] = __('Femme', true);
				break;
			case 'm':
				$userProfiles['UserProfile']['sex'] = __('Homme', true);
				break;
			default:
				$userProfiles['UserProfile']['sex'] = __('Inconnu', true);
		}
		?>
	<table>
		<tr>
			<td><?php __('Sexe :'); ?></td>
			<td><?php echo $userProfiles['UserProfile']['sex']; ?></td>
		</tr>
		<tr>
			<td><?php __('Site :'); ?></td>
			<td><?php echo $this->Html->link($userProfiles['UserProfile']['url']); ?></td>
		</tr>
		<tr>
			<td><?php __('Date de naissance :'); ?></td>
			<td><?php echo $userProfiles['UserProfile']['birthday']; ?></td>
		</tr>
		<tr>
			<td><?php __('Membre depuis :'); ?></td>
			<td><?php echo $this->Time->timeAgoInWords($userProfiles['User']['created']); ?></td>
		</tr>
		<tr>
			<td><?php __('Dernière visite :'); ?></td>
			<td><?php 
			if($this->Time->wasWithinLast('5 minutes', $userProfiles['UserProfile']['lastseen'])) {
				echo '<strong>' . __('En ligne', true) . '</strong>';
			} else {
				echo $this->Time->timeAgoInWords($userProfiles['UserProfile']['lastseen']);
			}
			?></td>
		</tr>
	</table>
</div>
<div class="clear"></div>
<div id="user-informations" class="span-12 prepend-2 ircube-box last">
	<h2 class="orange">Salons fréquentés</h2>
	<div class="box orange">
		<ul>
			<?php
				foreach($userProfiles['Channel'] as $channel) {
					echo '<li>' . $html->link($channel['channel'], $ircube->channelProfileUrl($channel['channel'])) . '</li>';
				}
			?>
		</ul>
	</div>
</div>
<div class="clear"></div>
<a name="comments"></a><h2><?php printf(__('Commentaires (%d)', true), $userProfiles['UserProfile']['comment_count']); ?></h2>
<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function() {
	$('div#comments > ol#commentlist').load('<?php echo Router::url(array('controller' => 'comments', 'action' => 'display', 'user_profile', $userProfiles['UserProfile']['id'])); ?>');
});
</script>
<div id="comments">
	<div id="loader" style="width:100%;text-align:center;" class="clear"> 
	    <?php echo $this->Html->image('ajax-loader.gif'); ?> 
	</div>
	<ol class="commentlist" id="commentlist">
	</ol>
</div>
<div class="clear"></div>
<?php
if(isset($AuthUser['id']) && $AuthUser['id'] > 0) {
?>
<div id="comment_form">
<?php
echo $this->element('comment_form', array('model_id' => $userProfiles['UserProfile']['id'], 'model' => 'UserProfile'));
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