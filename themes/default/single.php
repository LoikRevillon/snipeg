<?php include('header.php'); ?>

<?php include('top.php'); ?>

<div id="main" class="container_12">

	<form action="" method="post">

		<div id="single" class="grid_9">

			<h1><?php echo $Lang->snippetviewpage; ?></h1>

			<div id="single-box">

				<h4><a href="#"><?php echo htmlspecialchars($Snippet->name); ?></a></h4>

				<p><?php echo $Lang->publishedbyview . ' ' . htmlspecialchars($User->name) . ' ' . $Lang->publisheddateview . ' ' . date('M d Y', $Snippet->lastUpdate) . ' ' . $Lang->in; ?> <a href="?action=browse&category=<?php echo htmlspecialchars($Snippet->category); ?>"><?php echo htmlspecialchars($Snippet->category); ?></a></p>

				<!-- TODO : REIMPLEMENT CLEANLY
				<div id="single-snippet">

					<pre><?php /* echo htmlspecialchars($Snippet->content); */ ?></pre>

				</div>
				-->

				<textarea name="snippet-content" id="snippet-content" ><?php echo htmlspecialchars($Snippet->content); ?></textarea>

			</div>

		</div>

		<input type="hidden" name="snippet-id" value="<?php echo $Snippet->id; ?>" />

		<div class="grid_3">

			<div id="single-about">

				<p><img src="<?php echo $User->avatar; ?>" /></p>

				<div id="action">

					<input type="submit" name="edit-snippet" value="<?php echo $Lang->editbutton; ?>" />

					<div class="clear"></div>

					<input type="submit" name="delete-snippet" value="<?php echo $Lang->removebutton; ?>" />

				</div>

			</div>

			<div class="clear"></div>

			<div class="tags">

				<?php if(!empty($Snippet->tags)) : ?>

				<?php foreach($Snippet->tags AS $tag) : ?>

				<a href="?action=browse&tag=<?php echo htmlspecialchars($tag); ?>"><?php echo htmlspecialchars($tag); ?></a>

				<?php endforeach; ?>

				<?php endif; ?>

			</div>

		</div>

	</form>

</div>

<?php include('footer.php'); ?>