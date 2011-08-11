<?php include('header.php'); ?>

<?php include('top.php'); ?>

<div id="main" class="container_12">

	<form method="get" action="test.search.php" id="search" autocomplete="off" class="prefix_3 grid_6">

		<input name="query" type="text" id="query" autofocus />

		<input name="dosearch" type="submit" value="Search" />

	</form>

</div>

<div class="container_12">

	<div id="results"></div>

</div>

<?php include('footer.php'); ?>