<?php include('header.php'); ?>

<?php include('top.php'); ?>

<div id="main" class="container_12">

	<div id="new">

	<?php if (empty($Snippet)) : ?>
		<h1><?php echo $Lang->addsnippetpage; ?></h1>

		<form method="post" action="?action=new" id="add-snippet">
	<?php else : ?>
		<h1><?php echo $Lang->editsnippetpage; ?></h1>

		<form method="post" action="?action=edit&id=<?php echo $Snippet->id; ?>" id="add-snippet">
	<?php endif; ?>

			<div id="add-snippet-main" class="grid_7">

				<label for id="snippet-name"><?php echo $Lang->titlesnippet; ?></label>
				<div class="clear"></div>
				<input type="text" name="name" id="snippet-name" value="<?php if (!empty($Snippet->name)) { echo htmlspecialchars($Snippet->name); } ?>" autofocus />
				<div class="clear"></div>

				<label for id="snippet-description"><?php echo $Lang->descriptionsnippet; ?></label>
				<div class="clear"></div>
				<input type="text" name="description" id="snippet-description" value="<?php if (!empty($Snippet->comment)) { echo htmlspecialchars($Snippet->comment); } ?>" />
				<div class="clear"></div>

				<label for id="snippet-tags"><?php echo $Lang->tagssnippet; ?></label>
				<div class="clear"></div>
				<input type="text" name="tags" id="snippet-tags" value="<?php if (!empty($Snippet->tags)) { echo htmlspecialchars(implode( ', ', $Snippet->tags)); } ?>" />
				<div class="clear"></div>

				<label for="snippet-content"><?php echo $Lang->codesnippet; ?></label>
				<div class="clear"></div>
				<textarea name="content" id="snippet-content"><?php if (!empty($Snippet->content)) { echo htmlspecialchars($Snippet->content); } ?></textarea>
				<div class="clear"></div>

				<?php if (empty($Snippet)) : ?>
					<input type="submit" name="addsnippet" value="<?php echo $Lang->addsnippetpage; ?>" />
				<?php else : ?>
					<input type="submit" name="edit-snippet" value="<?php echo $Lang->editsnippetpage; ?>" />
				<?php endif; ?>

			</div>

			<div id="add-snippet-side" class="prefix_1 grid_4">

				<label for="new-category"><?php echo $Lang->newcategorysnippet; ?></label>
				<div class="clear"></div>
				<input type="text" name="newcategory" id="new-category" placeholder="<?php echo $Lang->newcategorynamesnippet; ?>" />
				<div class="clear"></div>

				<label for="snippet-category"><?php echo $Lang->setcategorysnippet; ?></label>
				<div class="clear"></div>
				<select name="category" id="snippet-category">

				<?php if (!empty($Categories)) :
					foreach($Categories as $category) :

						if (!empty($Snippet) AND $Snippet->category === $category) :?>
							<option value="<?php echo htmlspecialchars($category); ?>" selected="selected"><?php echo htmlspecialchars(ucfirst($category)); ?></option>
						<?php else : ?>

						<option value="<?php echo htmlspecialchars($category); ?>"><?php echo htmlspecialchars(ucfirst($category)); ?></option>

						<?php endif; ?>

				<?php endforeach;
				else : ?>

					<option value="default">Default</option>

				<?php endif; ?>

                </select>
				<div class="clear"></div>

				<label for="snippet-language"><?php echo $Lang->programminglangsnippet; ?></label>

				<div class="clear"></div>

				<select name="language" id="snippet-language">
					<option value="0" selected="selected">None</option>
					<?php $favorite_language = array_intersect( $Geshi_codes, $User->favorite_lang ); ?>
					<?php foreach( $favorite_language as $code => $lang_name ) : ?>
					<?php if ( !empty( $Snippet ) AND $Snippet->language === $code ) : ?>
					<option value="<?php echo $code;?>" selected="selected"><?php echo htmlspecialchars( ucfirst( $lang_name ) );?></option>
					<?php else : ?>
					<option value="<?php echo $code;?>"><?php echo htmlspecialchars( ucfirst( $lang_name ) );?></option>
					<?php endif; ?>
					<?php endforeach; ?>
				</select>

				<div class="clear"></div>

				<label for="snippet-is-public"><?php echo $Lang->privacysnippet; ?></label>
				<div class="clear"></div>

				<fieldset id="radio-fieldset">

					<input type="radio" name="private" id="snippet-is-public" value="0" <?php if(empty($Snippet) OR empty($Snippet->privacy)){ echo 'checked="checked"'; } ?>/><label for="snippet-is-public"><?php echo $Lang->publicsnippet; ?></label>
					<div class="clear"></div>

					<input type="radio" name="private" id="snippet-is-private" value="1" <?php if(!empty($Snippet) AND !empty($Snippet->privacy)){ echo 'checked="checked"'; } ?>/><label for="snippet-is-private"><?php echo $Lang->privatesnippet; ?></label>
					<div class="clear"></div>

				</fieldset>

			</div>

		</form>

	</div>

</div>

<?php include('footer.php'); ?>
