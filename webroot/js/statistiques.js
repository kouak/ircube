var refresh_timer;

$(function() {
	$('#refresh-stats').click(function() {
		refreshImages(false);
		clearInterval(refresh_timer);
		refresh_timer = setInterval('refreshImages(false)',30000);
		return false;
	});
	refreshImages(true);
	refresh_timer = setInterval('refreshImages(false)',30000);
});

function refreshImages(load) {
	$('img.stats').each(function () {
		var height = $(this).height();
		var width = $(this).width();
		$(this).hide();
		if(load == false) {
			/* refresh => keep size of the image and apply to the div */
			$(this).parent('div.loader').height($(this).height()).width($(this).width());
		}
		$(this).parent('div.loader').addClass('loading');
		var url = $(this).attr("src").split("?");
		$(this).load(function() {
			$(this).parent('div.loader').removeClass('loading');
			$(this).fadeIn('slow');
		}).attr("src", url[0] + '?nocache=' + (new Date()).getTime());
	});
}