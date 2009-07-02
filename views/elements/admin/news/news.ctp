<div class="clear"></div>
<div class="container news <?php 
	if($news['News']['published'] == 0) {
		echo "unpublished";
	}
	else {
		echo $news['NewsType']['classe'];  
	}?>">
	<div class="news_header span-24 last container">
		<div class="news_date span-3">
			<span class="news_date_day"><?php echo $time->format('d', $news['News']['created']); ?></span>
			<span class="news_date_my"><?php echo up($time->format('M', $news['News']['created'])) . '<br />' . $time->format('Y', $news['News']['created']);?></span>
		</div>
		<div class="news_title span-19"><h2><?php echo $html->link($news['News']['title'],
											array(
										    'controller' => 'news',
										    'action' => 'view',
										    'id' => $news['News']['id'],
										    'slug' => $news['News']['permalink'],
											)
										);
				?></h2>
		</div>
		<div class="span-2 last">
			<span style="float: right; height: 16px; position: relative; top: 50%; margin-top: -8px; display:block; padding: 0;">
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
								array('escape' => false, 'class' => 'edit')
								);

				echo $html->link($html->image('delete.png', array('alt' => __('Supprimer', true))),
								array('controller' => 'news', 'action' => 'delete', $news['News']['id']),
								array('escape' => false, 'class' => 'delete')
								);
			?>
			</span>
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