<?php
$javascript->link(array('jquery/jquery-cakephp-pagination'), false);
$html->css(array('admin/comments', 'loading'), null, array(), false);
?>
<script type="text/javascript">
$(document).ready(function() {
	loadPiece("<?php echo $html->url(array('controller'=>'news_comments','action'=>'admin_index', 'admin' => true));?>","#commentlist", function() {}); /* Pagination */
});
</script>
<h1><?php __('Dernier commentaires :'); ?></h1>
<div id="commentlist"></div>