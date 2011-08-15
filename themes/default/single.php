<?php include('header.php'); ?>

<?php include('top.php'); ?>

<div id="main" class="container_12">

	<div id="single" class="grid_9">

		<h1><?php echo $Lang->snippetviewpage; ?></h1>

		<div id="single-box">

			<h4><a href="#">Enable Hidden Admin Feature displaying ALL Site Settings</a></h4>

			<p><?php echo $Lang->publishedbyview; ?> John <?php echo $Lang->publisheddateview; ?> <?php echo date('M d Y'); ?> <?php echo $Lang->in; ?> <a href="#">Wordpress</a></p>

			<p>This little piece of code does something pretty cool. It will add an additional option to your settings menu with a link to "all settings".</p>

			<div id="single-snippet">

<pre>&lt;ul class=&quot;tweetFavList&quot;&gt;
	&lt;li&gt;
		&lt;p&gt;The text of the tweet goes here&lt;/p&gt;
		&lt;div class=&quot;info&quot;&gt;
			&lt;a title=&quot;Go to Tutorialzine's twitter page&quot; class=&quot;user&quot; href=&quot;http://twitter.com/Tutorialzine&quot;&gt;Tutorialzine&lt;/a&gt;
			&lt;span title=&quot;Retweet Count&quot; class=&quot;retweet&quot;&gt;19&lt;/span&gt;
			&lt;a title=&quot;Shared 3 days ago&quot; target=&quot;_blank&quot; class=&quot;date&quot; href=&quot;http://twitter.com/Tutorialzine/status/98439169621241856&quot;&gt;3 days ago&lt;/a&gt;
		&lt;/div&gt;
		&lt;div class=&quot;divider&quot;&gt;&lt;/div&gt;
	&lt;/li&gt;
&lt;/ul&gt;</pre>

			</div>

		</div>

	</div>

	<div class="grid_3">

		<div id="single-about">

			<p><img src="<?php echo DEFAULT_AVATAR; ?>" /></p>

			<div id="action">

				<input type="button" value="Edit" />
				<div class="clear"></div>
				
				<input type="button" value="Remove" />

			</div>

		</div>

		<div class="clear"></div>

		<div class="tags">

			<a href="#">You</a>
			<a href="#">Are</a>
			<a href="#">Not</a>
			<a href="#">Alone</a>
			<a href="#">In</a>
			<a href="#">This</a>
			<a href="#">Fucking</a>
			<a href="#">World</a>

		</div>

	</div>

</div>

<?php include('footer.php'); ?>