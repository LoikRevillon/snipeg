<?php include ('header.php'); ?>

<?php include ('top.php'); ?>

<div id="main" class="container_12">

	<div id="admin" class="prefix_1 grid_10">

		<h1>Users list</h1>

		<div class="userlist-line alpha grid_5">

			<div class="alpha grid_3">

				<h3>Username</h3>
				<p>Last Modification date</p>

				<form method="post" action="">

					<fieldset>

						<input type="checkbox" name="isadmin" id="is-admin-1" />
						<label for="is-admin-1">User is admin</label>

						<div class="clear"></div>

						<input type="checkbox" name="islocked" id="is-locked-1" />
						<label for="is-locked-1">Lock this user</label>
						
						<div class="clear"></div>

						<input type="checkbox"name="delete" id="delete-1" />
						<label for="delete-1">Delete this user</label>
						
						<div class="clear"></div>

						<input type="hidden" name="id" value="1" />

					</fieldset>

					<input name="doadmin" type="submit" value="Update" />

				</form>

			</div>

			<div class="grid_2 omega">

				<img src="style/images/avatar.png" />

			</div>

		</div>

		<div class="userlist-line alpha grid_5">

			<div class="alpha grid_3">

				<h3>Username</h3>
				<p>Last Modification date</p>

				<form method="post" action="">

					<fieldset>

						<input type="checkbox" name="isadmin" id="is-admin-2" />
						<label for="is-admin-2">User is admin</label>

						<div class="clear"></div>

						<input type="checkbox" name="islocked" id="is-locked-2" />
						<label for="is-locked-2">Lock this user</label>
						
						<div class="clear"></div>

						<input type="checkbox"name="delete" id="delete-2" />
						<label for="delete-2">Delete this user</label>
						
						<div class="clear"></div>

						<input type="hidden" name="id" value="2" />

					</fieldset>

					<input name="doadmin" type="submit" value="Update" />

				</form>

			</div>

			<div class="grid_2 omega">

				<img src="style/images/avatar.png" />

			</div>

		</div>

	</div>

</div>

<?php include ('footer.php'); ?>