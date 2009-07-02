<?php
/* A news without comments */
$html->css(array('actualites'), null, array(), false);
$javascript->link(array('actualites-corners'), false);
?>
<div class="clear"></div>
<div class="container news <?php echo $news['NewsType']['classe']; ?>">
	<div class="news_header span-24 last container">
		<div class="news_date span-3">
			<span class="news_date_day"><?php echo $time->format('d', $news['News']['created']); ?></span>
			<span class="news_date_my"><?php echo up($time->format('M', $news['News']['created'])) . '<br />' . $time->format('Y', $news['News']['created']);?></span>
		</div>
		<div class="news_title span-21 last"><h2><?php echo $html->link($news['News']['title'],
											array(
										    'controller' => 'news',
										    'action' => 'view',
										    'id' => $news['News']['id'],
										    'slug' => $news['News']['permalink'],
											)
										);
				?></h2>
		</div>
	</div>
	<div class="clear"></div>
	<div class="news_content">
		<?php echo $news['News']['content']; ?>
	</div>
	<div class="clear"></div>
	<div class="news_author"><span class="fleft;"><?php
		echo $html->link(sprintf(__('%d Commentaire' . (($news['News']['news_comment_count'] > 1) ? 's' : ''), true), $news['News']['news_comment_count']),
			array(
		    'controller' => 'news',
		    'action' => 'view',
		    'id' => $news['News']['id'],
		    'slug' => $news['News']['permalink'] . '#comments',
			)
		);
		if(!empty($news['NewsType']['titre'])) {
			echo ' - '
				.$html->link($news['NewsType']['titre'],
							array('controller' => 'news', 'action' => 'index', 'cat' => $news['NewsType']['titre'])
							);
		}
		?> - <?php echo __('Posté par ', true) . $profileHelper->link(null, $news['Author']);?>
	</div>
</div>