<?php
$before = <<<EOF
$('ol#commentlist').hide();
$('div#comments > div#loader').show();
EOF;
$this->Paginator->options(
	array(
		'update' => 'ol#commentlist',
		'url' => $this->passedArgs,
		'before' => $before,
		)
);
/* Modulus */
$mod = 4;
echo $this->Html->css(array('comments'), null, array(), false);
?>
<script type="text/javascript">
$(document).ready(function() {
	/* CakePHP JsHelper workaround */
	$('div#comments > div#loader').hide();
	$('ol#commentlist').show();
});
</script>
<div class="paging">
	<div class="pages">
<?php
	echo $this->Paginator->prev('<< ', array('class' => 'left'), '<< ', array('class'=>'disabled'));
	echo $this->Paginator->numbers(array('modulus' => $mod, 'separator' => '', 'first' => 1, 'last' => 1));
	echo $this->Paginator->next(' >>', array('class' => 'right'), ' >>', array('class'=>'disabled')); 
?>
	</div>
	<div class="selectfilter">
	<?php
	echo $this->Paginator->sort('Ordre', 'created');
	/* TODO : CSS : add space below paginator */
	?>
	</div>
</div>
<div class="clear"></div>
<br /><br />
<?php
$i = ($this->Paginator->params['paging']['Comment']['options']['page'] - 1) * $this->Paginator->params['paging']['Comment']['options']['limit'] + 1;
foreach($comments as $comment) {
	echo $this->element('comment', array('i' => $i, 'comment' => $comment));
	$i++;
}
?>
<script type="text/javascript">
$(function() {
	$('div.ircube-box > h1, div.ircube-box > h2, div.ircube-box > h3').corners("10px top");
	$('div.ircube-box > div.noheader').corners("10px");
	$('div.ircube-box > div.box').corners("10px bottom");
});
</script>
<?php
/* Outputs jQuery generated javascript */
echo $this->Js->writeBuffer();
?>