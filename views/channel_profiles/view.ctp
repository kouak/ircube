<?php
debug($channelProfile);
?>
<div class="channelProfiles view">
<h2><?php  __('ChannelProfile');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $channelProfile['ChannelProfile']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $channelProfile['ChannelProfile']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $channelProfile['ChannelProfile']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Channel'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $html->link($channelProfile['Channel']['id'], array('controller'=> 'channels', 'action'=>'view', $channelProfile['Channel']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Description'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $channelProfile['ChannelProfile']['description']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div>
	<h1>Qui fréquente ce salon ?</h1>
	<ul>
		<?php
			foreach($channelProfile['UserProfile'] as $up) {
				echo '<li>' . $html->link($up['username'], array('controller' => 'user_profiles', 'action' => 'view', 'username' => $up['username'])) . '</li>';
			}
		?>
	</ul>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('Edit ChannelProfile', true), array('action'=>'edit', $channelProfile['ChannelProfile']['id'])); ?> </li>
		<li><?php echo $html->link(__('Delete ChannelProfile', true), array('action'=>'delete', $channelProfile['ChannelProfile']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $channelProfile['ChannelProfile']['id'])); ?> </li>
		<li><?php echo $html->link(__('List ChannelProfiles', true), array('action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New ChannelProfile', true), array('action'=>'add')); ?> </li>
		<li><?php echo $html->link(__('List Channels', true), array('controller'=> 'channels', 'action'=>'index')); ?> </li>
		<li><?php echo $html->link(__('New Channel', true), array('controller'=> 'channels', 'action'=>'add')); ?> </li>
	</ul>
</div>
