<?php include('header.php'); ?>

<?php include('top.php'); ?>

<div id="main" class="container_12">

	<form action="" method="post">

		<div id="single" class="grid_9">

			<h1><?php echo $Lang->snippetviewpage; ?></h1>

			<div id="single-box">

				<h4><a href="#"><?php echo $Snippet->name; ?></a></h4>

				<p><?php echo $Lang->publishedbyview . ' ' . $User->name . ' ' . $Lang->publisheddateview . ' ' . date('M d Y', $Snippet->lastUpdate) . ' ' . $Lang->in; ?> <a href="?action=view&category=<?php echo $Snippet->category; ?>"><?php echo $Snippet->category; ?></a></p>

				<p><?php echo $Snippet->category; ?></p>

				<div id="single-snippet">

					<pre><?php echo $Snippet->content; ?></pre>

				</div>

				<textarea name="snippet-content" id="snippet-content" ><?php echo $Snippet->content; ?></textarea>

			</div>

		</div>

		<input type="hidden" name="snippet-id" value="<?php echo $Snippet->id; ?>" />

		<div class="grid_3">

			<div id="single-about">

				<p><img src="<?php echo $User->avatar; ?>" /></p>

				<div id="action">

					<input type="submit" name="edit-snippet" value="Edit" />
					
					<div class="clear"></div>
					
					<input type="submit" name="delete-snippet" value="Removve" />

				</div>

			</div>

			<div class="clear"></div>

			<div class="tags">

<?php			if (!empty($snippet->tags)) :
					foreach($snippet->tags AS $tag) :
?>

				<a href="?action=browse&tag='<?php echo $tag; ?>'"><?php echo $tag; ?></a>

<?php
				endforeach;
				endif;
?>

			</div>

		</div>

	</form>

</div>

<?php include('footer.php'); ?>