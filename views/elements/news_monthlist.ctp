<?php
/* Element which renders a block containing links to news in a selected month */
?>
<div id="loader" style="width:100%;text-align:center;display: none;" class="clear"> 
    <?php echo $html->image('ajax-loader.gif'); ?> 
</div>

<div id="monthlist">
<div class="paging">
	<?php
	if(!empty($nav['prev']))
	{
	?>
		<div style="float:left;"><?php
		echo $ajax->link( 
		       '« ' . $nav['prev']['Month'] . '/' . $nav['prev']['Year'], 
		       array(	'controller' => 'news', 
						'action' => 'getNewsByMonth',
						//'2006/07'
		                 $nav['prev']['Year'] . '/' . $nav['prev']['Month']
					), 
		       array(	'update' => 'monthlist', 
						'loading' => "$('loader').show(); $('monthlist').hide();", 
						'loaded' => "$('loader').hide(); $('monthlist').show();") 
		    );?></div>
	<?php
	}
	?>

	<?php
	if(!empty($nav['next']))
	{
	?>
		<div style="float:right;"><?php
		echo $ajax->link( 
		       $nav['next']['Month'] . '/' . $nav['next']['Year']. ' »', 
		       array(	'controller' => 'news', 
						'action' => 'getNewsByMonth',
						//'2006/07'
		                 $nav['next']['Year'] . '/' . $nav['next']['Month']
					), 
			       array(	'update' => 'monthlist', 
							'loading' => "$('loader').show(); $('monthlist').hide();", 
							'loaded' => "$('loader').hide(); $('monthlist').show();")
		    );?></div>
	<?php
	}
	?>
	</div>
	<div class="clear"></div>
<h2><?php echo __('Année : ', true) . $nav['cur']['Year']; ?></h2><em><?php echo __('Mois : ', true).$nav['cur']['Month']; ?></em>
<ul>
<?php

foreach ($news as $news):
$i=1;
?>	
	<li><?php echo $html->link( date('j.n.y', strtotime($news['News']['created'])) . ' : ' . $news['News']['title'] ,array(
	    'controller' => 'news',
	    'action' => 'view',
	    'id' => $news['News']['id'],
	    'slug' => $news['News']['permalink']
	)); ?></li>
<?php
endforeach;
?>
<?php
if(!isset($i))
	echo '<li>' . __('Pas de news pour le mois sélectionné', true) . '</li>';
?>
</ul>

</div>