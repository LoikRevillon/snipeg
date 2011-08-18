<?php include('header.php'); ?>

<?php include('top.php'); ?>

<?php $currentPage = (!empty($_GET['page'])) ? $_GET['page'] : 1; ?>

<div id="main" class="container_12">

	<div id="browse">

		<h1><?php echo $Lang->browsepage;
		if (!empty($Pages)) : echo ' ( ' . $Lang->pagenumberbeginbrowse . $currentPage . ' ' . $Lang->of . ' ' . end($Pages) . ' ) '; endif;?></h1>

<?php	foreach($Snippets AS $snippet) : ?>

		<div class="browse-line">

			<div class="grid_7">

				<h4><a href="?action=single&id=<?php echo $snippet->id; ?>"><?php echo $snippet->name; ?></a></h4>
				<p><?php echo $snippet->comment; ?></p>
				<p><?php echo $Lang->publishedbyview . ' ' . $User->name . ' ' . $Lang->publisheddateview . ' ' . date('M d Y', $snippet->lastUpdate) . ' ' . $Lang->in . ' <a href="?action=view&category=' . $snippet->category . '">' . $snippet->category . '</a>';?></p>

			</div>

			<div class="prefix_1 grid_4">

				<div class="tags">
					
<?php			if (!empty($snippet->tags)) :
					foreach($snippet->tags AS $tag) :
?>

					<a href="?action=browse&tag=<?php echo $tag; ?>"><?php echo $tag; ?></a>

<?php
				endforeach;
				endif;
?>
				</div>

			</div>

		</div>

<?php	endforeach; ?>

	</div>

<?php if (!empty($Pages)) : ?>
	<div id="paging">		
		<a href="?action=browse&page=1"><?php echo $Lang->first; ?></a>			
<?php foreach ($Pages AS $key => $numPage) :
		if ($key < count($Pages) - 1) :?>
		<a href="?action=browse&page=<?php echo $numPage; ?>"><?php echo $numPage ?></a>	
<?php	endif;
	endforeach; ?>
		<a href="?action=browse&page=<?php echo end($Pages); ?>"><?php echo $Lang->last; ?></a>
	</div>
<?php endif; ?>

</div>

<?php include('footer.php'); ?>