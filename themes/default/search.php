<?php include('header.php'); ?>

<?php include('top.php'); ?>

		<div id="main" class="container_12">

			<form method="get" action="" id="search" class="prefix_3 grid_6" autocomplete="off">

				<input type="hidden" name="action" value="search" />

				<input type="text" name="query" id="query" value="<?php remind_get('query'); ?>" autofocus />

				<input type="submit" name="dosearch" value="<?php echo $Lang->searchbutton; ?>" />

			</form>

		</div>

		<div class="container_12">

			<div id="search-head">

				<?php if(!empty($_GET['query'])) : ?>

				<h1><?php echo $Lang->resultsfor;?> : <?php echo htmlspecialchars($_GET['query']); ?></h1>

				<?php endif; ?>

				<?php if(is_array($Snippets) AND !empty($Snippets)) : ?>

				<?php foreach($Snippets AS $snippet) : ?>

				<div class="result-line">

					<div class="grid_7">

						<h4><a href="?action=single&id=<?php echo htmlspecialchars($snippet->id); ?>"><?php echo htmlspecialchars($snippet->name); ?></a></h4>

						<p><?php echo htmlspecialchars($snippet->comment); ?></p>

						<p><?php echo $Lang->publisheddatebrowse . ' ' . date('M d Y', $snippet->lastUpdate) . ' ' . $Lang->categorybrowse ; ?> <a href="?action=browse&category=<?php echo htmlspecialchars($snippet->category); ?>"><?php echo htmlspecialchars(ucfirst($snippet->category)); ?></a></p>
					</div>

					<div class="prefix_1 grid_4">

						<div class="tags">

							<?php if(!empty($snippet->tags)) : ?>

							<?php foreach($snippet->tags as $tag) : ?>

							<a href="?action=browse&tags=<?php echo htmlspecialchars($tag); ?>"><?php echo htmlspecialchars(ucfirst($tag)); ?></a>

							<?php endforeach; ?>

							<?php endif; ?>

						</div>

					</div>

				</div>

				<?php endforeach; ?>

				<?php endif; ?>

			</div>

			<div id="results"></div>

		</div>

		<script type="text/javascript">
			$(document).ready(function() {
				instantSearch();
			});

			function instantSearch() {

				var request;
				var requestPage = "<?php echo $Theme->location . 'instantsearch.php'; ?>";
				var runningRequest = false;

				$('input#query').keyup(function(e) {

					if(e.which == 13)
						return;

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

				});

			};
		</script>
	</body>
</html>