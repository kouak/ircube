$(function() {
	
	$('#menubar > ul > li').click(function() {
		/* Take care of the first menu line */

		$('#menubar > ul > li').removeClass('clicked');
		$(this).addClass('clicked');
		
		var index = $(this).attr('id').charAt($(this).attr('id').length - 1);
		
		/* If it's a link, follow it and that's it */
		if($(this).children('a').attr('href') != undefined) {
			return true;
		}

		/* Add second line */
		$('#submenubar > ul').hide();
		$('#submenubar > ul#subitem' + index).show();
	});
	

	
	
	$('#submenubar > ul').hide();
	$('#submenubar > ul.visible').show();

});