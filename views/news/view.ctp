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
		echo $this->element('news', array('news' => $news));	
	?>
</div>
<div class="clear"></div>
<h2><?php echo __('Commentaires :', true) ;?></h2>
<div class="clear"></div>
<ol class="commentlist" id="commentlist">
	
<?php
/* Todo : element comment */
$i = 1;
App::import('Helper', 'Time');
$time = new TimeHelper();
foreach($news['NewsComment'] as $newsComment)
{
?>
	  <li id="#comment-<?php echo $i?>">
		<cite class="meta"> 
			<img alt="Avatar" src='http://ircube.org/images/avatars/mini/bfe328761f87392cfa8970917927ea90.jpg' class="avatar avatar-96" />
				<span class="permlink"><a href="#comment-11628" title="Permanent link to this comment">#<?php echo $i; ?></a></span> 
				<span class="author">
					<?php echo $html->link($newsComment['User']['username'], '/viewprofile/' . $newsComment['User']['username']); ?>
				</span> 
				<span class="date"><?php echo $time->niceShort($newsComment['created']); ?></span> 
		</cite>
		<p>Nunc hendrerit, arcu et vulputate rhoncus, tellus elit porta orci, sit amet aliquam arcu quam ut libero. Morbi nisi lacus, dictum eget, laoreet ac, tempus in, urna. In sapien felis, condimentum in, porta ut, mollis ut, mauris. Vivamus sit amet nunc in arcu aliquam tristique.</p> 
	</li>
<?php
$i++;
}
?>
</ol>