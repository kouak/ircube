<?php
$html->css(array('comments'), null, array(), false);
?>
<h1><?php echo __('Archives des actualit&eacute;s :', true); ?></h1>
<div class="paging">
	<?php
	if(isset($neighbors['prev']))
	{
	?>
		<div style="float:right;"><?php
		echo $html->link($neighbors['prev']['News']['title']. ' »', array(
		    'controller' => 'news',
		    'action' => 'view',
		    'id' => $neighbors['prev']['News']['id'],
		    'slug' => $neighbors['prev']['News']['permalink']
		));
		?></div>
	<?php
	}
	?>
	<?php
	if(isset($neighbors['next']))
	{
	?>
		<div style="float:left;"><?php
		echo $html->link('« ' . $neighbors['next']['News']['title'], array(
		    'controller' => 'news',
		    'action' => 'view',
		    'id' => $neighbors['next']['News']['id'],
		    'slug' => $neighbors['next']['News']['permalink']
		));
		?></div>
	<?php
	}
	?>
</div>
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