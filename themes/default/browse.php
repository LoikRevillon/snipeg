<?php include('header.php'); ?>

<?php include('top.php'); ?>

<?php

	$currentPage =(!empty($_GET['page'])) ? $_GET['page'] : 1;

	if(!empty($_GET['tags']))
		$extra = $Lang->tag . ' : ' . htmlspecialchars($_GET['tags']);
	elseif(!empty($_GET['category']))
		$extra = $Lang->category . ' : ' . htmlspecialchars($_GET['category']);
	elseif(!empty($Pages))
		$extra = '( ' . $Lang->pagenumberbeginbrowse . $currentPage . ' ' . $Lang->of . ' ' . end($Pages) . ' )';
	else
		$extra = '';
?>

<div id="main" class="container_12">

	<div id="browse">

		<h1><?php echo $Lang->browsepage . ' '. $extra; ?></h1>

		<?php foreach($Snippets as $snippet) : ?>

		<div class="browse-line">

			<div class="grid_7">

				<h4><a href="?action=single&id=<?php echo $snippet->id; ?>"><?php echo htmlspecialchars($snippet->name); ?></a></h4>
				<p><?php echo Tool::linkify(htmlspecialchars($snippet->comment)); ?></p>
				<p><?php echo $Lang->publishedbyview . ' ' . htmlspecialchars($snippet->owner->name) . ' ' . $Lang->publisheddateview . ' ' . date('M d Y', $snippet->lastUpdate) . ' ' . $Lang->in . ' <a href="?action=browse&category=' . htmlspecialchars($snippet->category) . '">' .
htmlspecialchars(ucfirst($snippet->category)) . '</a>';?></p>

			</div>

			<div class="prefix_1 grid_4">

				<div class="tags">

					<?php if(!empty($snippet->tags)) : ?>

					<?php foreach($snippet->tags AS $tag) : ?>

						<a href="?action=browse&tags=<?php echo htmlspecialchars($tag); ?>"><?php echo htmlspecialchars($tag); ?></a>

					<?php endforeach; ?>

					<?php endif; ?>

				</div>

			</div>

		</div>

		<?php endforeach; ?>

	</div>

	<?php if(!empty($Pages)) : ?>

		<?php if ( isset( $_GET['tags'] ) ) : ?>

		<div class="clear"></div>

		<div id="paging">

			<a href="?action=browse&tags=<?php echo htmlspecialchars( $_GET['tags'] );?>&page=1"><?php echo $Lang->first; ?></a>

			<?php foreach($Pages AS $key => $numPage) : ?>

				<?php if($key < count($Pages) - 1) : ?>

					<a href="?action=browse&tags=<?php echo htmlspecialchars( $_GET['tags'] );?>&page=<?php echo $numPage; ?>"><?php echo $numPage ?></a>

				<?php endif; ?>

			<?php endforeach; ?>

			<a href="?action=browse&tags=<?php echo htmlspecialchars( $_GET['tags'] );?>&page=<?php echo end($Pages); ?>"><?php echo $Lang->last; ?></a>

		</div>

		<?php elseif ( isset ( $_GET['category'] ) ) : ?>

		<div class="clear"></div>

		<div id="paging">

			<a href="?action=browse&category=<?php echo htmlspecialchars( $_GET['category'] );?>&page=1"><?php echo $Lang->first; ?></a>

			<?php foreach($Pages AS $key => $numPage) : ?>

				<?php if($key < count($Pages) - 1) : ?>

					<a href="?action=browse&category=<?php echo htmlspecialchars( $_GET['category'] );?>&page=<?php echo $numPage; ?>"><?php echo $numPage ?></a>

				<?php endif; ?>

			<?php endforeach; ?>

			<a href="?action=browse&category=<?php echo htmlspecialchars( $_GET['category'] );?>&page=<?php echo end($Pages); ?>"><?php echo $Lang->last; ?></a>

		</div>

		<?php else : ?>

		<div class="clear"></div>

		<div id="paging">

			<a href="?action=browse&page=1"><?php echo $Lang->first; ?></a>

			<?php foreach($Pages AS $key => $numPage) : ?>

				<?php if($key < count($Pages) - 1) : ?>

					<a href="?action=browse&page=<?php echo $numPage; ?>"><?php echo $numPage ?></a>

				<?php endif; ?>

			<?php endforeach; ?>

			<a href="?action=browse&page=<?php echo end($Pages); ?>"><?php echo $Lang->last; ?></a>

		</div>

		<?php endif; ?>

	<?php endif; ?>

</div>

<?php include('footer.php'); ?>
