$(document).ready(function(){
	$("#autoComplete").autocomplete(
	{
		serviceUrl: '/user_profiles/autoComplete',
		minChars: 2,
		delimiter: "\n",
		onSelect: selectItem,
		deferRequestBy: 300,
	});
});

function selectItem(li) {
	findValue(li);
}

function findValue(li) {
	if( li == null ) return alert("No match!");

	// if coming from an AJAX call, let's use the product id as the value
	if( !!li.extra ) var sValue = li.extra[0];

	// otherwise, let's just display the value in the text box
	else var sValue = li.selectValue;

	alert("The value you selected was: " + sValue);
}