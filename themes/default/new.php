<?php include('header.php'); ?>

<?php include('top.php'); ?>

<div id="main" class="container_12">

	<div id="new">

		<h1><?php echo $Lang->addsnippetpage; ?></h1>

		<form method="post" action="" id="add-snippet">

			<div id="add-snippet-main" class="grid_7">

				<label for id="snippet-name">Title</label>
				<div class="clear"></div>
				<input type="text" name="name" id="snippet-name" autofocus />
				<div class="clear"></div>

				<label for id="snippet-description">Description</label>
				<div class="clear"></div>
				<input type="text" name="description" id="snippet-description" />
				<div class="clear"></div>

				<label for id="snippet-tags">Tags (comma separated)</label>
				<div class="clear"></div>
				<input type="text" name="tags" id="snippet-tags" />
				<div class="clear"></div>

				<label for="snippet-content">Code</label>
				<div class="clear"></div>
				<textarea name="content" id="snippet-content"></textarea>
				<div class="clear"></div>

				<input type="submit" name="addsnippet" value="<?php echo $Lang->addsnippetpage; ?>" />

			</div>

			<div id="add-snippet-side" class="prefix_1 grid_4">

				<label for="new-category"><?php echo $Lang->newcategorysnippet; ?></label>
				<div class="clear"></div>
				<input type="text" name="newcategory" id="new-category" placeholder="<?php echo $Lang->newcategorynamesnippet; ?>" />
				<div class="clear"></div>

				<label for="snippet-category"><?php echo $Lang->setcategorysnippet; ?></label>
				<div class="clear"></div>
				<select name="category" id="snippet-category">
					<option value="default">Default</option>
					<option value="miscellaneous">Miscellaneous</option>
					<option value="wordpress">Wordpress</option>
				</select>
				<div class="clear"></div>

				<label for="snippet-language"><?php echo $Lang->programminglangsnippet; ?></label>
				<div class="clear"></div>
				<select name="language" id="snippet-language">
						<option value="html">HTML</option>
						<option value="php">PHP</option>
						<option value="js">Javascript</option>
				</select>
				<div class="clear"></div>

				<label for="snippet-is-public"><?php echo $Lang->privacysnippet; ?></label>
				<div class="clear"></div>

				<fieldset id="radio-fieldset">

					<input type="radio" name="private" id="snippet-is-public" value="0" checked="checked"/><label for="snippet-is-public"><?php echo $Lang->publicsnippet; ?></label>
					<div class="clear"></div>

					<input type="radio" name="private" id="snippet-is-private" value="1"/><label for="snippet-is-private"><?php echo $Lang->privatesnippet; ?></label>
					<div class="clear"></div>

				</fieldset>

			</div>

		</form>

	</div>

</div>

<?php include('footer.php'); ?>