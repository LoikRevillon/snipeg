<?php include ('header.php'); ?>

<?php include ('top.php'); ?>

<div id="main" class="container_12">

	<div id="settings">

		<h1>Account Settings ( John Williams )</h1>

		<form method="post" action="" enctype="multipart/form-data">

			<div id="settings-first-line">

				<div class="alpha grid_4">

					<img src="style/images/avatar.png" />

					<div class="clear"></div>

					<div id="settings-submit">

						<input type="submit" value="Update Account Settings" />

					</div>

				</div>

				<div class="grid_4">

					<fieldset>

						<h3>Global Settings</h3>

						<label>Email</label>
						<div class="clear"></div>
						<input name="email" type="text" value="example@example.org" />
						<div class="clear"></div>

						<label>Language</label>
						<div class="clear"></div>
						<select>
							<option>English</option>
						</select>
						<div class="clear"></div>

						<label>Change Avatar</label>
						<div class="clear"></div>
						<input type="file" />
						<div class="clear"></div>

					</fieldset>

				</div>

				<div class="grid_4 omega">

					<fieldset>

						<h3>Change Password</h3>

						<label>Actual password</label>
						<div class="clear"></div>
						<input name="" type="password" />
						<div class="clear"></div>
						<label>New Password</label>
						<div class="clear"></div>
						<input name="" type="password" />
						<div class="clear"></div>
						<label>New Password (Retype)</label>
						<div class="clear"></div>
						<input name="" type="password" />
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