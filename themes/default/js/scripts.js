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

$(document).ready(function() {

	var request;
	var requestPage = "test.search.php";
	var runningRequest = false;

	$('input#query').keyup(function(e) {

		e.preventDefault();
		var $q = $(this);

		if($q.val() == ''){
			$('div#results').html('');
			return false;
		}

		if(runningRequest)
			request.abort();

		runningRequest = true;
		request = $.getJSON(requestPage, { q:$q.val() }, function(data) {
			showResults(data, $q.val());
			runningRequest = false;
		});

		function showResults(data) {

			var result = '';

			$.each(data, function(i, item){
				result += '<div class="result">';
				result += '<h2><a href="#">' + data.title + '</a></h2>';
				result += '<p>' + data.post +'</p>';
				result += '</div>';
			});

			$('div#results').html(result);

		}

		$('form').submit(function(e){
			e.preventDefault();
		});

	});

});

/*
 * Uniform
*/

$(document).ready(function() {

	$('select, input:checkbox, input:radio, input:submit, input:button').uniform();

});

/*
 * Browser detection (Firefox / Opera Fix stylesheet)
*/

$(document).ready(function() {

	if($.browser.mozilla || $.browser.opera) {

		var lnk = $('<link>');

		lnk.attr({
			href: 'style/style-fix.css',
			rel: 'stylesheet'
		});

		$('head').append(lnk);

	}

});
