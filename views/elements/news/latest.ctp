<?php
echo $html->css(array('news/latest', 'ircube-boxes'), null, array('inline' => false));
?>
<div id="latestNews" class="ircube-box <?php echo $span; ?>">
				<h2 class="<?php echo $class; ?>"><?php echo $html->link(__('Dernières nouvelles', true), array('controller' => 'news', 'action' => 'index')); ?></h2>
				<div class="box <?php echo $class; ?>">
					<ul>
						<?php
foreach ($latestNews as $news) {
echo '
						<li>
							'.$html->link($time->format('d/m/y', $news['News']['created']) . ' ' . $news['News']['title'],
																array(
															    'controller' => 'news',
															    'action' => 'view',
															    'id' => $news['News']['id'],
															    'slug' => $news['News']['permalink'],
																)
															) . '
						</li>';
}
						?>
					</ul>
				</div>
</div>