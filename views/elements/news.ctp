<?php
/* A news without comments */
$html->css(array('actualites'), null, array(), false);
?>
<div class="clear"></div>
<div class="news <?php echo $news['NewsType']['classe']; ?>">
	<div class="news_header">
		<div class="news_date">
			<p class="news_date_day"><?php echo $time->format('d', $news['News']['created']); ?></p>
			<p class="news_date_my"><?php echo up($time->format('M', $news['News']['created'])) . ' ' . $time->format('Y', $news['News']['created']);?></p>
		</div>
		<div class="news_title"><h2><?php echo $html->link($news['News']['title'],
											array(
										    'controller' => 'news',
										    'action' => 'view',
										    'id' => $news['News']['id'],
										    'slug' => $news['News']['permalink'],
											)
										);
				?></h2><?php
					if(!empty($news['NewsType']['titre']))
						echo '<p>'
							.__('Catégorie : ', true)
							.$html->link($news['NewsType']['titre'],
														array('controller' => 'news', 'action' => 'index', 'cat' => $news['NewsType']['titre'])
														)
							."</p>\n";
							
		?></div>
		<div class="fright" style="margin: 2px">
			<?php
			if($adminPanel == true) {
				echo $html->link($html->image('edit.png'),
								array('controller' => 'news', 'action' => 'edit', $news['News']['id']),
								array('escape' => false,)
								);

				echo $html->link($html->image('delete.png'),
								array('controller' => 'news', 'action' => 'delete', $news['News']['id']),
								array('escape' => false),
								__('Etes-vous sûr ?', true)
								);
			}
			?>
		</div>
	</div>
	<div class="clear"></div>
	<div class="news_content">
		<?php echo $news['News']['content']; ?>
	</div>
	<div class="clear"></div>
	<div class="news_author"><span class="fleft;"><?php
		echo (($news['News']['news_comment_count'] > 0) ? $news['News']['news_comment_count'] : __('Aucun', true)) . ' ' . (($news['News']['news_comment_count'] > 1) ? Inflector::pluralize(__('Commentaire', true)) : __('Commentaire', true));
		echo ' - ';
		echo $html->link(__('Permalien', true),
											array(
										    'controller' => 'news',
										    'action' => 'view',
										    'id' => $news['News']['id'],
										    'slug' => $news['News']['permalink'],
										)); ?> - <?php echo __('Posté par ', true) . $profileHelper->link(null, $news['Author']); ?>
	</div>
</div>