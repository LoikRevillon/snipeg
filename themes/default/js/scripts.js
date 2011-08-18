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

function instantSearch(requestPage) {

	var request;
	var runningRequest = false;

	$('input#query').keyup(function(e) {

		e.preventDefault();
		var $q = $(this);

		if($q.val() == ''){
			$('div#results').html('');
			$('#search-head').html('');
			return false;
		}

		if(runningRequest)
			request.abort();

		runningRequest = true;
		request = $.getJSON(requestPage, { 'dosearch': '', 'query': $q.val() }, function(data) {
			if(data != null)
				showResults(data, $q.val());
			runningRequest = false;
		});

		function showResults(data) {

			var result = '';

			$.each(data, function(i, item){

				// PHP timestamp : seconds, Javascript timestamp : milliseconds
				var update = new Date();
				update.setTime(item.lastUpdate * 1000);

				result += '<div class="result-line">';
				result += '<div class="grid_7">';
				result += '<h4><a href="?action=single&id=' + item.id + '">' + protect(item.name) + '</a></h4>';
				result += '<p>' + protect(item.comment) + '</p>';
				result += '<p>Published on ' + update.toLocaleString() + ' in category <a href="?action=browse&category=' + protect(item.category) + '">' + protect(ucfirst(item.category))  + '</a></p>';
				result += '</div>';
				result += '<div class="prefix_1 grid_4">';
				result += '<div class="tags">';

				$.each(item.tags.toString().split(','), function(j, itm) {
					if(itm != '')
						result += '<a href="?action=browse&tags=' + protect(itm) + '">' + protect(ucfirst(itm)) + '</a>';
				});

				result += '</div>';
				result += '</div>';
				result += '</div>';

			});

			$('div#results').html(result);

			$('#search-head').html('<h1>Results for : ' + protect($('#query').val()) + '</h1>');

		}

		$('form').submit(function(e){
			e.preventDefault();
		});

	});

};

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