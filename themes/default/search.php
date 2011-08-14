<?php include('header.php'); ?>

<?php include('top.php'); ?>

<div id="main" class="container_12">

	<form method="get" action="" id="search" class="prefix_3 grid_6" autocomplete="off">

		<input type="hidden" name="action" value="search" />

		<input type="text" name="query" id="query" autofocus />

		<input type="submit" name="dosearch" value="Search" />

	</form>

</div>

<div class="container_12">

	<div id="search-head"></div>

	<div id="results"></div>

</div>

<?php include('footer.php'); ?>