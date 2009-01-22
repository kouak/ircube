<div id="module_content" class="two_columns">
	<div id="left_zone">
		<div id="news_bloc">
			<h2><?php __('News');?></h2>
			<?php
			foreach ($news as $news) {
				echo $this->element('news', array('news' => $news));
			}
			?>
			<div style="text-align: right;margin-bottom: 5px;">
				<?php echo $html->link(__('Archives des actualités', true), array('controller' => 'news', 'action' => 'index')); ?>- <a href="http://feeds.feedburner.com/Ircube"><img src="http://ircube.org/images/feed-icon-14x14.png" alt="Flux RSS des actualit&eacute;s" /></a>
			</div>
		</div>
	</div>
	
	<div id="right_zone">
		<div id="pix_bloc">
			<h2><?php __('IRCube, c\'est quoi ?')?></h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam condimentum elit vel mi. Sed condimentum, velit dignissim dictum aliquet, mi diam vestibulum tellus, sed accumsan turpis elit rutrum augue. Nam vitae nulla. In hac habitasse platea dictumst. Donec lorem. Ut quam ante, volutpat nec, elementum eget, elementum ac, nibh. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
			
		</div>
		
		<div id="join_bloc">
			<h2><?php __('Rejoignez-nous !'); ?></h2>
			<p>
				Ut bibendum dui at urna. Maecenas faucibus. Aenean massa nunc, hendrerit vitae, porttitor vitae, scelerisque eget, nisl. Pellentesque fermentum. Duis ornare. Donec varius porta nibh. In hac habitasse platea dictumst. Suspendisse dolor mauris, dictum pharetra, fermentum a, hendrerit sed, dolor. Sed velit nulla, gravida a, dictum vel, posuere vel, est. Nam sagittis elementum lorem. Fusce molestie pede nec quam. Nulla tempus neque. Quisque diam. Donec suscipit pellentesque ligula.
			</p>
		
		<div id="linkus_bloc">
			<h2><?php __('Participez'); ?></h2>
			<p>
Ut bibendum dui at urna. Maecenas faucibus. Aenean massa nunc, hendrerit vitae, porttitor vitae, scelerisque eget, nisl. Pellentesque fermentum. Duis ornare. Donec varius porta nibh. In hac habitasse platea dictumst. Suspendisse dolor mauris, dictum pharetra, fermentum a, hendrerit sed, dolor. Sed velit nulla, gravida a, dictum vel, posuere vel, est. Nam sagittis elementum lorem. Fusce molestie pede nec quam. Nulla tempus neque. Quisque diam. Donec suscipit pellentesque ligula.
			</p>
		</div>
		
		<div id="partners_bloc">
			<h2><?php __('Un membre au hasard'); ?></h2>
			<p>
Ut bibendum dui at urna. Maecenas faucibus. Aenean massa nunc, hendrerit vitae, porttitor vitae, scelerisque eget, nisl. Pellentesque fermentum. Duis ornare. Donec varius porta nibh. In hac habitasse platea dictumst. Suspendisse dolor mauris, dictum pharetra, fermentum a, hendrerit sed, dolor. Sed velit nulla, gravida a, dictum vel, posuere vel, est. Nam sagittis elementum lorem. Fusce molestie pede nec quam. Nulla tempus neque. Quisque diam. Donec suscipit pellentesque ligula.
			</p>
		</div>

	</div>
</div>
