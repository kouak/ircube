/** 
 * Loads in a URL into a specified divName, and applies the function to 
 * all the links inside the pagination div of that page (to preserve the ajax-request) 
 * @param string href The URL of the page to load 
 * @param string divName The name of the DOM-element to load the data into 
 * @return boolean False To prevent the links from doing anything on their own. 
 */ 

var loadPieceCurrentUrl;

function loadPiece(href,divName, callback) {
	var divPaginationLinks = divName+" #pagination a";
	loadPieceCurrentUrl = href;
	if($('#loading-img').length == 0) {
		$(divName + ' #pagination').append('<img src="/img/ajax-loader-snake.gif" alt="" id="loading-img" />');
	} else {
		return false;
	}
	
	$(divName).load(href, {}, function(){
		$('#loading-img').remove();
		if(callback != undefined) {
			callback();
		}
		$(divPaginationLinks).click(function() {
			var thisHref = $(this).attr("href");
			loadPiece(thisHref,divName, callback);
			return false; 
		}); 
	}); 
}