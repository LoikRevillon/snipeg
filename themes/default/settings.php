<?php include ('header.php'); ?>

<?php include ('top.php'); ?>

<?php

/*
 * Theme <select> content
*/

$themeSelectOptions = '';

foreach($ThemesList as $themeDirName) {

	$themeSelectOptions .= '<option value="' . $themeDirName . '"';

	if($User->theme == $themeDirName)
		$themeSelectOptions .= ' selected="selected"';

	$themeSelectOptions .= '>' . htmlspecialchars(ucfirst($themeDirName)) . '</option>'."\n";

}

/*
 * Language <select> content
*/

$langSelectOptions = '';

foreach($LangsList as $lang) {

	$langSelectOptions .= '<option value="' . $lang->filename . '"';

	if($User->language == $lang->filename)
		$langSelectOptions .= ' selected="selected"';

	$langSelectOptions .= '>' . htmlspecialchars(ucfirst($lang->name)) . '</option>'."\n";

}

?>

<div id="main" class="container_12">

	<div id="settings">

		<h1><?php echo $Lang->accountpage; ?> ( <?php echo htmlspecialchars(ucfirst($User->name)); ?> )</h1>

		<form method="post" action="" enctype="multipart/form-data" autocomplete="off">

			<div id="settings-first-line">

				<div class="alpha grid_4">

					<img src="<?php echo $User->avatar; ?>" />
					<div class="clear"></div>

					<label id="theme-label" for="theme"><?php echo $Lang->themelabelaccount; ?></label>
					<div class="clear"></div>
					<select name="theme" id="theme">
						<?php echo $themeSelectOptions; ?>
					</select>

					<div class="clear"></div>
					<div id="settings-submit">
						<label for="updateaccount"><?php echo $Lang->validate; ?></label>
						<div class="clear"></div>
						<input type="submit" name="updateaccount" id="updateaccount" value="<?php echo $Lang->updateaccountsettings; ?>" />
					</div>

				</div>

				<div class="grid_4">

					<fieldset>

						<h3><?php echo $Lang->globalsettingaccount; ?></h3>

						<label><?php echo htmlspecialchars($Lang->emailaccount); ?></label>
						<div class="clear"></div>
						<input type="text" name="email" value="" />
						<div class="clear"></div>

						<label><?php echo $Lang->langaccount; ?></label>
						<div class="clear"></div>
						<select name="language" id="language">
							<?php echo $langSelectOptions; ?>
						</select>
						<div class="clear"></div>

						<label><?php echo $Lang->avataraccount; ?></label>
						<div class="clear"></div>
						<input type="file" name="new-avatar" />
						<div class="clear"></div>

					</fieldset>

				</div>

				<div class="grid_4 omega">

					<fieldset>

						<h3><?php echo $Lang->passwordaccount; ?></h3>

						<label><?php echo $Lang->actualpasswordaccount; ?></label>
						<div class="clear"></div>
						<input type="password" name="oldpassword" />
						<div class="clear"></div>

						<label><?php echo $Lang->newpasswordaccount; ?></label>
						<div class="clear"></div>
						<input type="password" name="newpassword-1" />
						<div class="clear"></div>

						<label><?php echo $Lang->newpasswordagainaccount; ?></label>
						<div class="clear"></div>
						<input type="password" name="newpassword-2" />
						<div class="clear"></div>

					</fieldset>

				</div>

			</div>

			<div id="settings-second-line">

				<h3><?php echo $Lang->programminglangaccount;?></h3>

					<?php foreach( $Geshi_codes as $code => $value ) : ?>
						<?php if ( $code !== 0 ) : ?>
					<div class="grid_3">
						<?php if ( in_array( $value, $User->favorite_lang ) ) : ?>
					<input name="<?php echo htmlspecialchars( $code );?>" type="checkbox" id="<?php echo htmlspecialchars( $code );?>" checked="checked">
						<?php else : ?>
					<input name="<?php echo htmlspecialchars( $code );?>" type="checkbox" id="<?php echo htmlspecialchars( $code );?>">
						<?php endif; ?>
					<label for="<?php echo htmlspecialchars( $code );?>"><?php echo htmlspecialchars( ucfirst( $value ) );?></label>
					</div>
						<?php endif; ?>
					<?php endforeach; ?>
			</div>

		</form>

	</div>

</div>

<?php include ('footer.php'); ?>
