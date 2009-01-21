<?php 

$paginator->options(array('url' =>  $this->passedArgs));
/* Set modulus here */
$mod = 4;
?>
<h1><?php __('Archives des actualités :'); ?></h1>
<div class="paging">
	<div class="pages">
<?php 
	echo $paginator->prev('<< ', array('class' => 'left'), '<< ', array('class'=>'disabled'));
	echo $paginator->numbers(array('modulus' => $mod, 'separator' => '', 'first' => 1, 'last' => 1));
	echo $paginator->next(' >>', array('class' => 'right'), ' >>', array('class'=>'disabled')); 
?>
	</div>
	<div class="selectfilter">
	<?php	echo $form->select('cat', $newstypes, null, array('onChange' => 'window.location=this.options[this.selectedIndex].value;'), (isset($this->params['pass'][0])) ? $this->params['pass'][0] : __('Filtrer une catégorie', true));
	?>
	</div>
</div>
<div class="clear"></div>
<div id="news_bloc">
	<?php
	foreach ($news as $news)
	{
		echo $this->element('news', array('news' => $news));	
	}
	?>
</div>