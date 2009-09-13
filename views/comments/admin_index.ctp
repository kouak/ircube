<?php
$javascript->link(array('jquery/jquery-cakephp-pagination'), false);
$html->css(array('admin/comments', 'loading'), null, array(), false);
?>
<script type="text/javascript">
$(document).ready(function() {
	loadPiece("<?php echo $this->here;?>","#commentlist", function() {}); /* Pagination */
});
</script>
<h1><?php __('Dernier commentaires :'); ?></h1>
<div id="commentlist"></div>