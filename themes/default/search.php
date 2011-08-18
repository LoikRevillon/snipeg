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
		</script>
	</body>
</html>