<?php
$javascript->link('jquery/jquery-cakephp-pagination', false);
$html->css(array('actualites', 'loading'), null, array(), false);
/* Set modulus here */
?>
<script type="text/javascript"> 
	$(document).ready(function() {
		loadPiece("<?php echo $html->url(array('controller'=>'news','action'=>'admin_index', 'admin' => true));?>","#news_bloc"); 
	}); 
</script>
<h1><?php __('Archives des actualités :'); ?></h1>
<div id="news_bloc"></div>