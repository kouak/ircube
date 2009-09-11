<?php
$html->css(array('comments', 'ircube-boxes'), null, array(), false);
?>
<h1><?php echo __('Archives des actualit&eacute;s :', true); ?></h1>
<div class="clear"></div>
<div id="news_bloc">
	<?php
		echo $this->element('news/news', array('news' => $news));	
	?>
</div>
<div class="clear"></div>
<a name="comments"></a><h2><?php printf(__('Commentaires (%d)', true), count($news['NewsComment'])); ?></h2>
<div class="clear"></div>
<ol class="commentlist" id="commentlist">
<?php
$i = 1;
$javascript->link(array('jquery/jquery-form'), false);
foreach($news['NewsComment'] as $newsComment) {
	echo $this->element('comment', array('i' => $i, 'comment' => $newsComment));
	$i++;
}
if(isset($AuthUser['id']) && $AuthUser['id'] > 0) {
?>
<div class="clear"></div>
<div id="news_comment_form">
<?php
echo $this->element('news/news_comment_form', array('news_id' => $news['News']['id']));
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
</ol>
<div class="clear"></div>