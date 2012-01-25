<?php include('header.php'); ?>

<?php include('top.php'); ?>

		<div id="main" class="container_12">

			<form method="get" action="" id="search" class="prefix_3 grid_6" autocomplete="off">

				<input type="hidden" name="action" value="search" />

				<input type="text" name="query" id="query" value="<?php remind_get('query'); ?>" autofocus />

				<input type="submit" value="<?php echo $Lang->searchbutton; ?>" />

				<div class="clear"></div>

				<div class="alpha grid_6">

					<input type="checkbox" id="filterByCategory" />

					<label id="category-label" for="filterByCategory" ><?php echo $Lang->categoryfilter;?></label>

					<select name="category" id="category">

						<?php foreach( $Categories as $cat ) : ?>
						<option value="<?php echo htmlspecialchars( $cat );?>"><?php echo ucfirst( htmlspecialchars( $cat ) );?></option>
						<?php endforeach; ?>

					</select>

				</div>

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

						<p><?php echo Tool::linkify(htmlspecialchars($snippet->comment)); ?></p>

						<p><?php echo $Lang->publishedbyview . ' ' . htmlspecialchars($snippet->owner) . ' ' . $Lang->publisheddatebrowse . ' ' . date('M d Y', $snippet->lastUpdate) . ' ' . $Lang->categorybrowse ; ?> <a href="?action=browse&category=<?php echo htmlspecialchars($snippet->category); ?>"><?php echo htmlspecialchars(ucfirst($snippet->category)); ?></a></p>
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

				<?php if(!empty($Pages)) : ?>

				<div class="clear"></div>

				<div id="paging">

					<?php if ( isset( $_GET['query'] ) ) : ?>

						<a href="?action=search&query=<?php echo htmlspecialchars( $_GET['query'] ); ?>&page=1"><?php echo $Lang->first; ?></a>

						<?php foreach($Pages AS $key => $numPage) : ?>

							<?php if($key < count($Pages) - 1) : ?>

								<a href="?action=search&query=<?php echo htmlspecialchars( $_GET['query'] ); ?>&page=<?php echo $numPage; ?>"><?php echo $numPage ?></a>

							<?php endif; ?>

						<?php endforeach; ?>

						<a href="?action=search&query=<?php echo htmlspecialchars( $_GET['query'] ); ?>&page=<?php echo end($Pages); ?>"><?php echo $Lang->last; ?></a>

					<?php elseif ( isset( $_GET['category'] ) ) : ?>

						<a href="?action=search&category=<?php echo htmlspecialchars( $_GET['category'] ); ?>&page=1"><?php echo $Lang->first; ?></a>

						<?php foreach($Pages AS $key => $numPage) : ?>

							<?php if($key < count($Pages) - 1) : ?>

								<a href="?action=search&category=<?php echo htmlspecialchars( $_GET['category'] ); ?>&page=<?php echo $numPage; ?>"><?php echo $numPage ?></a>

							<?php endif; ?>

						<?php endforeach; ?>

						<a href="?action=search&category=<?php echo htmlspecialchars( $_GET['category'] ); ?>&page=<?php echo end($Pages); ?>"><?php echo $Lang->last; ?></a>

					<?php endif; ?>

				</div>

				<?php endif; ?>

				<?php endif; ?>

			</div>

			<div id="results"></div>

		</div>

		<script type="text/javascript">
			$(document).ready(function() {
				instantSearch();
				filterByCategory();
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
					var $c = ( undefined !== typeof $( 'select[name="category"]' ) ) ?
						$('select[name="category"] option').filter(':selected').val() :
						'';

					if($q.val() == ''){
						$('div#results').html('');
						$('#search-head').html('');
						return false;
					}

					if(runningRequest)
						request.abort();

					runningRequest = true;
					request = $.getJSON(requestPage, { 'query': $q.val(), 'category' : $c }, function(data) {
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
							result += '<p><?php echo $Lang->publishedbyview; ?> ' + protect(item.owner) + ' <?php echo $Lang->publisheddateview; ?> ' + update.toLocaleString() + ' <?php echo $Lang->categorybrowse; ?> <a href="?action=browse&category=' + protect(item.category) + '">' + protect(ucfirst(item.category))  + '</a></p>';
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

			function filterByCategory()
			{
				$( '#filterByCategory' ).css( 'margin-top : 10px' );
				<?php if ( in_array( 'category', $_GET ) ) : ?>
					$( '#filterByCategory').attr( 'checked', 'checked' );
				<?php else : ?>
					$( '#category' ).attr( 'name', '' ).parent( 'div' ).hide();
				<?php endif; ?>

				$( '#filterByCategory' ).click( function( e )
				{
					if ( $( this ).attr( 'checked' ) )
						$( '#category' ).attr( 'name', 'category' ).parent( 'div' ).fadeIn( 'fast' );

					else
						$( '#category' ).attr( 'name', '' ).parent( 'div' ).fadeOut( 'fast' )

					$( 'input#query' ).trigger( 'keyup' );
				} );

				$( '#category' ).click( function() { $( 'input#query' ).trigger( 'keyup' ); } );
			};
		</script>
	</body>
</html>
