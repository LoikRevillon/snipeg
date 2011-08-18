<?php include('header.php'); ?>

<?php include('top.php'); ?>

<?php $currentPage =(!empty($_GET['page'])) ? $_GET['page'] : 1; ?>

<div id="main" class="container_12">

	<div id="admin" class="prefix_1 grid_10">

		<h1><?php echo $Lang->adminpage; if(!empty($Pages)) { echo '( ' . $Lang->pagenumberbeginbrowse . $currentPage . ' ' . $Lang->of . ' ' . end($Pages) . ' ) '; } ?></h1>

		<?php foreach($Users AS $user) : ?>

		<?php if($User->id == $user->id) { continue; } // Don't show current user ?>

		<div class="userlist-line alpha grid_5">

			<div class="alpha grid_3">

				<h3><?php echo htmlspecialchars(ucfirst($user->name)); ?></h3>

				<p><?php echo $user->email; ?></p>

				<form method="post" action="?action=admin">

					<fieldset>

						<input type="checkbox" name="isadmin" id="is-admin-<?php echo $user->id; ?>" <?php if($user->isadmin) { echo 'checked';}?> />
						<label for="is-admin-<?php echo $user->id; ?>"><?php echo $Lang->becomeadmin; ?></label>

						<div class="clear"></div>

						<input type="checkbox" name="islocked" id="is-locked-<?php echo $user->id; ?>" <?php if($user->islocked) { echo 'checked';}?> />
						<label for="is-locked-<?php echo $user->id; ?>"><?php echo $Lang->lockuseradmin; ?></label>

						<div class="clear"></div>

						<input type="checkbox"name="delete" id="delete-<?php echo $user->id; ?>" />
						<label for="delete-<?php echo $user->id; ?>"><?php echo $Lang->deleteuseradmin; ?></label>

						<div class="clear"></div>

						<input type="hidden" name="id" value="<?php echo $user->id; ?>" />

					</fieldset>

					<input name="doadmin" type="submit" value="<?php echo $Lang->updatebutton; ?>" />

				</form>

			</div>

			<div class="grid_2 omega">

				<img src="<?php echo $user->avatar; ?>" />

			</div>
		</div>

		<?php endforeach; ?>

		<?php if(!empty($Pages)) : ?>

		<div class="clear"></div>

		<div id="paging">

			<a href="?action=admin&page=1"><?php echo $Lang->first; ?></a>

			<?php foreach($Pages AS $key => $numPage) : ?>

				<?php if($key < count($Pages) - 1) : ?>

					<a href="?action=admin&page=<?php echo $numPage; ?>"><?php echo $numPage ?></a>

				<?php endif; ?>

			<?php endforeach; ?>

			<a href="?action=admin&page=<?php echo end($Pages); ?>"><?php echo $Lang->last; ?></a>

		</div>

		<?php endif; ?>

	</div>

</div>

<?php include('footer.php'); ?>