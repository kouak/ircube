<?php
$javascript->link(array('jquery/jquery-cakephp-pagination', 'jquery/jquery.animateToClass'), false);
$html->css(array('actualites', 'loading'), null, array(), false);
/* Set modulus here */
?>
<script type="text/javascript">
function attachPublishjQuery(a) {
		a.click(function() {
		$(this).children('img').attr({src: "/img/ajax-loader-snake.gif", alt: "Loading", id: 'publish-loading'});
		var toReplace = $(this).parents('.news');
		$.post($(this).attr('href'), {}, function(data) {
			//alert(toReplace.attr('class'));
			//alert($(data).filter('.news').attr('class'));
			toReplace.attr('class', $(data).filter('.news').attr('class'));
			toReplace.find('a.publish, a.unpublish').replaceWith($(data).find('a.publish, a.unpublish').clone());
			attachPublishjQuery(toReplace.find('a.publish, a.unpublish'));
		}, "html");
		return false;
	});
	/* Toggle visibility */

}

$(document).ready(function() {
	loadPiece("<?php echo $html->url(array('controller'=>'news','action'=>'admin_index', 'admin' => true));?>","#news_bloc", function() {
		attachPublishjQuery($('.publish, .unpublish'));
		$('.news_content').hide();
		$('.news_header').click(function() {
			$(this).parent().children('.news_content').slideToggle('medium');
		});
		/* pagination + toggle visibility */
	});
});

</script>
<h1><?php __('Archives des actualités :'); ?></h1>
<div id="news_bloc"></div>