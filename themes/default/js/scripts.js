/*
 * Login form
*/

$(document).ready(function() {

	$('#signup').hide();
	$('#reset').hide();
	$('#show-signup').click(function(){
		$('#signin').hide();
		$('#signup').show(210);
	});
	$('#show-reset').click(function(){
		$('#signin').hide();
		$('#reset').show(210);
	});
	$('.show-signin').click(function(){
		$('#signup').hide();
		$('#reset').hide();
		$('#signin').show(210);
	});
});

/*
 * Instant Search
*/

function ucfirst(str) {

	if(str.length > 0)
		return str[0].toUpperCase() + str.substring(1);
	else
		return str;
 
}

/*
 * htmlspecialchars equivalent
*/

function protect(string) {

	return $('<span>').text(string).html();

}

/*
 * Uniform
*/

$(document).ready(function() {

	$('select, input:checkbox, input:radio, input:submit, input:button').uniform();

});