<?php include ('header.php'); ?>

<?php include ('top.php'); ?>

<div id="main" class="container_12">

	<div id="admin" class="prefix_1 grid_10">

		<h1>Users list</h1>

		<div class="userlist-line alpha grid_5">

			<form method="post" action="">

				<div class="alpha grid_3">

					<h3>Username</h3>
					<p>Last Modification date</p>

					<fieldset>

						<input name="admin" type="checkbox" id="admin-2" />
						<label for="admin-2">User is admin</label>
						<div class="clear"></div>

						<input name="lock" type="checkbox" id="lock-2" />
						<label for="lock-2">Lock this user</label>
						<div class="clear"></div>

						<input name="delete" type="checkbox" id="delete-2" />
						<label for="delete-2">Delete this user</label>
						<div class="clear"></div>

						<input name="id" type="hidden" value="2" />

					</fieldset>

					<input name="updateuser" type="submit" value="Update" />

				</div>

				<div class="grid_2 omega">

					<img src="style/images/avatar.png" />

				</div>

			</form>

		</div>

		<div class="userlist-line grid_5 alpha">

			<form method="post" action="">

				<div class="alpha grid_3">

					<h3>Username</h3>
					<p>Last Modification date</p>

					<fieldset>

						<input name="admin" type="checkbox" id="admin-3" />
						<label for="admin-3">User is admin</label>
						<div class="clear"></div>

						<input name="lock" type="checkbox" id="lock-3" />
						<label for="lock-3">Lock this user</label>
						<div class="clear"></div>

						<input name="delete" type="checkbox" id="delete-3" />
						<label for="delete-3">Delete this user</label>
						<div class="clear"></div>

						<input name="id" type="hidden" value="3" />

					</fieldset>

					<input name="updateuser" type="submit" value="Update" />

				</div>

				<div class="grid_2 omega">

					<img src="style/images/avatar.png" />

				</div>

			</form>

		</div>

	</div>

</div>

<?php include ('footer.php'); ?>