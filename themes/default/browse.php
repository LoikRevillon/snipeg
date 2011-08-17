<?php include('header.php'); ?>

<?php include('top.php'); ?>

<div id="main" class="container_12">

	<div id="browse">

		<h1><?php echo $Lang->browsepage; ?> (<?php echo $Lang->pagenumberbeginbrowse; ?> X <?php echo $Lang->of; ?> X)</h1>

		<div class="browse-line">

			<div class="grid_7">

				<h4><a href="">Enable Hidden Admin Feature displaying ALL Site Settings</a></h4>
				<p>This little piece of code does something pretty cool. It will add an additional option to your settings menu with a link to "all settings".</p>
				<p><?php echo $Lang->publishedbyview; ?> John <?php echo $Lang->publisheddateview; ?> <?php echo date('M d Y'); ?> <?php echo $Lang->in; ?> category <a href="#">Wordpress</a></p>

			</div>

			<div class="prefix_1 grid_4">

				<div class="tags">

					<a href="">wordpress</a>
					<a href="">hidden</a>
					<a href="">admin</a>
					<a href="">settings</a>

				</div>

			</div>

		</div>

	</div>

<?php if (!empty($Pages)) : ?>
	<div id="paging">		
		<a href="?action=admin&page=1"><?php echo $Lang->first; ?></a>			
<?php foreach ($Pages AS $numPage) : ?>
		<a href="?action=admin&page=<?php echo $numPage; ?>"><?php echo $numPage ?></a>			
<?php endforeach; ?>
		<a href="?action=admin&page=<?php echo end($Pages); ?>"><?php echo $Lang->last; ?></a>
	</div>
<?php endif; ?>

</div>

<?php include('footer.php'); ?>