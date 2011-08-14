<?php include ('header.php'); ?>

<?php include ('top.php'); ?>

<div id="main" class="container_12">

	<div id="admin" class="prefix_1 grid_10">

		<h1><?php echo $Lang->adminpage; ?></h1>

		<div class="userlist-line alpha grid_5">

			<div class="alpha grid_3">

				<h3>Username</h3>
				<p>Last Modification date</p>

				<form method="post" action="">

					<fieldset>

						<input type="checkbox" name="isadmin" id="is-admin-1" />
						<label for="is-admin-1"><?php echo $Lang->becomeadmin; ?></label>

						<div class="clear"></div>

						<input type="checkbox" name="islocked" id="is-locked-1" />
						<label for="is-locked-1"><?php echo $Lang->lockuseradmin; ?></label>
						
						<div class="clear"></div>

						<input type="checkbox"name="delete" id="delete-1" />
						<label for="delete-1"><?php echo $Lang->deleteuseradmin; ?></label>
						
						<div class="clear"></div>

						<input type="hidden" name="id" value="1" />

					</fieldset>

					<input name="doadmin" type="submit" value="<?php echo $Lang->updatebutton; ?>" />

				</form>

			</div>

			<div class="grid_2 omega">

				<img src="style/images/avatar.png" />

			</div>

		</div>

	</div>

</div>

<?php include ('footer.php'); ?>