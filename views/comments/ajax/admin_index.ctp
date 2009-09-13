<div id="pagination" class="paging">
	<?php
		echo $paginator->prev('<< ', array('class' => 'left'), '<< ', array('class'=>'disabled'));
		echo $paginator->numbers(array('modulus' => 4, 'separator' => '', 'first' => 1, 'last' => 1));
		echo $paginator->next(' >>', array('class' => 'right'), ' >>', array('class'=>'disabled'));
	?>
</div>
<div class="clear"></div>
<ol class="commentlist" id="commentlist">
	<?php
	$i = 1;
	foreach ($comments as $comment) {
		echo $this->element('admin/comment', array('i' => $i, 'comment' => am($comment['Comment'], array('Author' => $comment['Author']))));
		$i++;
	}
	?>
</ol>