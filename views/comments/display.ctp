<?php
$success = <<< EOF
$('ol#commentlist').show();
$('div#comments > div#loader').hide();
EOF;

$before = <<<EOF
$('ol#commentlist').hide();
$('div#comments > div#loader').show();
EOF;

$this->Paginator->options(
	array(
		'update' => 'ol#commentlist',
		'url' => $this->passedArgs,
		'before' => $before,
		'success' => $success,
		)
);
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
<ol class="commentlist" id="commentlist">
<?php
echo $this->Paginator->sort('Ordre', 'created');
echo '<br/>';
echo $this->Paginator->prev();
echo $this->Paginator->numbers();
echo $this->Paginator->next();
//debug($this->Paginator);
$i = ($this->Paginator->params['paging']['Comment']['options']['page'] - 1) * $this->Paginator->params['paging']['Comment']['options']['limit'] + 1;
foreach($comments as $comment) {
	echo $this->element('comment', array('i' => $i, 'comment' => $comment));
	$i++;
}
?>
<?php
/* Outputs jQuery generated javascript */
echo $this->Js->writeBuffer();
?>
</ol>