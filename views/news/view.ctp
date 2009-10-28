<?php
$html->css(array('comments', 'ircube-boxes'), null, array('inline' => false));
?>
<h1><?php echo __('Archives des actualit&eacute;s :', true); ?></h1>
<div class="clear"></div>
<div id="news_bloc">
	<?php
		echo $this->element('news/news', array('news' => $news));	
	?>
</div>
<div class="clear"></div>
<a name="comments"></a><h2><?php printf(__('Commentaires (%d)', true), $news['News']['comment_count']); ?></h2>
<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function() {
	$('div#comments > ol#commentlist').load('<?php echo Router::url(array('controller' => 'comments', 'action' => 'display', 'sort' => 'created', 'direction' => 'asc', 'news', $news['News']['id'])); ?>');
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
echo $this->Javascript->link(array('jquery/jquery-form'), false);
echo $this->element('comment_form', array('model_id' => $news['News']['id'], 'model' => 'News'));
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