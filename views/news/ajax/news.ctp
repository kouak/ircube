<div id="pagination" class="paging">
	<?php
		echo $paginator->prev('<< ', array('class' => 'left'), '<< ', array('class'=>'disabled'));
		echo $paginator->numbers(array('modulus' => 4, 'separator' => '', 'first' => 1, 'last' => 1));
		echo $paginator->next(' >>', array('class' => 'right'), ' >>', array('class'=>'disabled'));
	?>
</div>
<div class="clear"></div>
<div id="news_bloc">
	<?php
	foreach ($news as $news) {
		echo $this->element('news', array('news' => $news));
	}
	?>
</div>