<?php include('header.php'); ?>

<?php include('top.php'); ?>

		<div id="main" class="container_12">

			<form method="get" action="" id="search" class="prefix_3 grid_6" autocomplete="off">

				<input type="hidden" name="action" value="search" />

				<input type="text" name="query" id="query" autofocus />

				<input type="submit" name="dosearch" value="<?php echo $Lang->searchbutton; ?>" />

			</form>

		</div>

		<div class="container_12">

			<div id="search-head"></div>

			<div id="results"></div>

		</div>

		<script type="text/javascript">
			$(document).ready(function() {
				if($.browser.mozilla || $.browser.opera) {
					var lnk = $('<link>');
					lnk.attr({
						rel: 'stylesheet',
						href: '<?php echo $Theme->location; ?>style/style-fix.css'
					});
					$('head').append(lnk);
				}
				instantSearch('<?php echo $Theme->location . 'instantsearch.php'; ?>');
			});

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
							result += '<p><?php echo $Lang->publisheddatebrowse; ?> ' + update.toLocaleString() + ' <?php echo $Lang->categorybrowse; ?> <a href="?action=browse&category=' + protect(item.category) + '">' + protect(ucfirst(item.category))  + '</a></p>';
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

						$('#search-head').html('<h1><?php echo $Lang->resultsfor; ?> : ' + protect($('#query').val()) + '</h1>');

					}

					$('form').submit(function(e){
						e.preventDefault();
					});

				});

			};
		</script>
	</body>
</html>