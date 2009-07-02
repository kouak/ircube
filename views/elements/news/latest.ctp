<script type="text/javascript">
$(function() {
	$('div.box').corners("10px bottom");
	$('#latestNews h1').corners("10px top");
});
</script>
<?php
$html->css(array('news/latest'), null, array(), false);
?>
<div id="latestNews" class="<?php echo $class; ?>">
				<h1><?php echo $html->link(__('Dernières nouvelles', true), array('controller' => 'news', 'action' => 'index')); ?></h1>
				<div class="box">
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