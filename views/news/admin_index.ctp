<?php
$javascript->link(array('jquery/jquery-cakephp-pagination'), false);
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

}
 
$(document).ready(function() {
	loadPiece("<?php echo $html->url(array('controller'=>'news','action'=>'admin_index', 'admin' => true));?>","#news_bloc", function() {
		$('.news_content').hide();

		$('div.news_header img.collapse').hide();
		$('div.news_header').toggle(function() {
			$(this).parent().children('div.news_content').slideDown(function() {
				$(this).parent().find('img.expand').hide();
				$(this).parent().find('img.collapse').show();
			});	
		}, function() {
			$(this).parent().children('div.news_content').slideUp(function() {
				$(this).parent().find('img.collapse').hide();
				$(this).parent().find('img.expand').show();
			});
		});
		
		$('a.edit').click(function() {
			top.location = $(this).attr('href');
			return false;
		});
		
		attachPublishjQuery($('.publish, .unpublish'));
		
		$('.news_header a.delete').click(function() {
			var c = confirm("Supprimer cette news ?");
			if(c) {
				$(this).children('img').attr({src: "/img/ajax-loader-snake.gif", alt: "Loading", id: 'delete-loading'});
				var toDelete = $(this).parents('div.news');
				$.ajax({
					type: "GET",
					url: $(this).attr('href'),
					dataType: "html",
					success: function(msg){
						toDelete.slideUp("medium", function() {
							$(this).remove();
						});
					}
				});
			}
			return false;
		});
		/* pagination + toggle visibility */
	});
});

</script>
<h1><?php __('News :'); ?></h1>
<div id="news_bloc"></div>