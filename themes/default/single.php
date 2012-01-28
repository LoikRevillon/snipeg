<?php include('header.php'); ?>

<?php include('top.php'); ?>

<div id="main" class="container_12">

	<form action="" method="post">

		<div id="single" class="grid_9">

			<h1><?php echo $Lang->snippetviewpage; ?></h1>

			<div id="single-box">

				<h4><a href="#"><?php echo htmlspecialchars($Snippet->name); ?></a></h4>

				<p><?php echo $Lang->publishedbyview . ' ' . htmlspecialchars($Snippet->owner->name) . ' ' . $Lang->publisheddateview . ' ' . date('M d Y', $Snippet->lastUpdate) . ' ' . $Lang->in; ?> <a href="?action=browse&category=<?php echo htmlspecialchars($Snippet->category); ?>"><?php echo htmlspecialchars($Snippet->category); ?></a></p>

				<div id="single-snippet">

					<?php show_highlighted_snippet( $Snippet ); ?>

				</div>

				<textarea name="snippet-content" id="snippet-content" style="display:none" ><?php echo htmlspecialchars($Snippet->content); ?></textarea>

			</div>

			<a id="toogle-show" href="#"><?php echo $Lang->showsnippetbutton;?></a>

		</div>

		<input type="hidden" name="snippet-id" value="<?php echo $Snippet->id; ?>" />

		<div class="grid_3">

			<div id="single-about">

				<p><img src="<?php echo $Snippet->owner->avatar; ?>" /></p>

				<div id="action">

					<a id="edit" href="?action=edit&id=<?php echo htmlspecialchars($Snippet->id); ?>"><?php echo $Lang->editbutton; ?></a>

					<div class="clear"></div>

					<input type="submit" name="delete-snippet" value="<?php echo $Lang->removebutton; ?>" />

				</div>

			</div>

			<div class="clear"></div>

			<div class="tags">

				<?php if(!empty($Snippet->tags)) : ?>

				<?php foreach($Snippet->tags AS $tag) : ?>

				<a href="?action=browse&tags=<?php echo htmlspecialchars($tag); ?>"><?php echo htmlspecialchars($tag); ?></a>

				<?php endforeach; ?>

				<?php endif; ?>

			</div>

		</div>

	</form>

</div>

<?php if ( !empty( $Snippet->language ) ) : ?>

<script type="text/javascript">

	$( document ).ready( function()
	{
		var snippetCode = $( '#snippet-content' );
		var snippetHighlight = $( '#single-snippet' );

		snippetCode.hide();

		$( '#toogle-show' ).click( function( e )
		{
			if ( snippetCode.is( ':hidden' ) )
			{
				$( this ).html( '<?php echo $Lang->showsnippethighlight;?>' );
				snippetHighlight.fadeOut( 'fast', function()
				{
					snippetCode.fadeIn( 'fast' );
				} );
			}
			else
			{
				$( this ).html( '<?php echo $Lang->showsnippetsource;?>' );
				snippetCode.fadeOut( 'fast', function()
				{
					snippetHighlight.fadeIn( 'fast' );
				} );
			}

			e.preventDefault();
		} );
	} );

</script>

<?php endif; ?>

<?php include('footer.php'); ?>
