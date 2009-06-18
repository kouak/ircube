<div class="clear"></div>
<div class="news <?php 
	if($news['News']['published'] == 0) {
		echo "unpublished";
	}
	else {
		echo $news['NewsType']['classe'];  
	}?>">
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
											'admin' => false
											)
										);
				?></h2><?php
					if(!empty($news['NewsType']['titre']))
						echo '<p>'
							.__('Catégorie : ', true)
							.$html->link($news['NewsType']['titre'],
														array('controller' => 'news', 'action' => 'index', 'cat' => $news['NewsType']['titre'], 'admin' => false)
														)
							."</p>\n";

		?></div>
		<div class="fright" style="margin: 2px">
			<?php
				echo $html->image('zoomin.png', array('alt' => __('Voir', true), 'class' => 'expand'));
				echo $html->image('zoomout.png', array('alt' => __('Cacher', true), 'class' => 'collapse'));

				if($news['News']['published'] == 0) {
					echo $html->link($html->image('refuse.png', array('alt' => __('Publier', true))),
								array('controller' => 'news', 'action' => 'publish', 'admin' => true, $news['News']['id']),
								array('escape' => false, 'class' => 'publish')
								);
				}
				else {
					echo $html->link($html->image('accept.png', array('alt' => __('Masquer', true))),
								array('controller' => 'news', 'action' => 'unpublish', 'admin' => true, $news['News']['id']),
								array('escape' => false, 'class' => 'unpublish')
								);
				}
				echo $html->link($html->image('edit.png', array('alt' => __('Editer', true))),
								array('controller' => 'news', 'action' => 'edit', $news['News']['id']),
								array('escape' => false,)
								);

				echo $html->link($html->image('delete.png', array('alt' => __('Supprimer', true))),
								array('controller' => 'news', 'action' => 'delete', $news['News']['id']),
								array('escape' => false, 'class' => 'delete')
								);
			?>
		</div>
	</div>
	<div class="clear"></div>
	<div class="news_content">
		<?php echo $news['News']['content']; ?>
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
</div>