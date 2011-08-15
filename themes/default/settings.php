<?php include ('header.php'); ?>

<?php include ('top.php'); ?>

<div id="main" class="container_12">

	<div id="settings">

		<h1><?php echo $Lang->accountpage; ?> ( John Williams )</h1>

		<form method="post" action="" enctype="multipart/form-data" autocomplete="off">

			<div id="settings-first-line">

				<div class="alpha grid_4">

					<img src="<?php echo $Theme->location; ?>style/images/avatar.png" />
					<div class="clear"></div>

					<label id="theme-label" for="theme"><?php echo $Lang->themelabelaccount; ?></label>
					<div class="clear"></div>
					<select name="theme" id="theme">
						<option value="default">Default</option>
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

						<label><?php echo $Lang->emailaccount; ?></label>
						<div class="clear"></div>
						<input type="text" name="email" value="" />
						<div class="clear"></div>

						<label><?php echo $Lang->langaccount; ?></label>
						<div class="clear"></div>
						<select name="language">
							<option value="en_EN">English</option>
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

				<?php include 'list.php'; ?>

			</div>

		</form>

	</div>

</div>

<?php include ('footer.php'); ?>