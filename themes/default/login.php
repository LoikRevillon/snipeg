<?php include('header.php'); ?>

<div id="topbar"></div>

<div id="main" class="container_12">

	<form method="post" action="" id="login" class="prefix_4 grid_4" autocomplete="off">

		<div id="signin">

			<h1><?php echo $Lang->loginsignin; ?></h1>

			<label for="login-name"><?php echo $Lang->loginnamelabel; ?> ( <a href="#" id="show-signup" tabindex="40"><?php echo $Lang->loginsignup; ?> !</a> )</label>
			<input type="text" name="signin-login" id="login-name" tabindex="10" autofocus />

			<label for="login-password"><?php echo $Lang->password; ?> ( <a id="show-reset" href="#" tabindex="50"><?php echo $Lang->forgotten; ?> ?</a> )</label>
			<input type="password" name="signin-password" id="login-password" tabindex="20" />

			<input type="submit" name="dologin" value="<?php echo $Lang->loginsignin; ?>" tabindex="30"/>

		</div>

		<div id="signup">

			<h1><?php echo $Lang->loginsignup; ?></h1>

			<p><a href="#" class="show-signin"><?php echo $Lang->show; ?> <?php echo $Lang->loginsignin; ?></a></p>

			<label id="signup-name"><?php echo $Lang->loginnamelabel; ?></label>
			<input type="text" name="signup-login" id="signup-name" />

			<label id="signup-email"><?php echo $Lang->email; ?></label>
			<input type="text" name="signup-email" id="signup-email" />

			<label id="signup-password-1"><?php echo $Lang->password; ?></label>
			<input type="password" name="signup-password-1" id="signup-password-1" />

			<label id="signup-password-2"><?php echo $Lang->password; ?> ( <?php echo $Lang->retype; ?> )</label>
			<input type="password" name="signup-password-2" id="signup-password-2" />
			
			<input type="submit" name="dosignup" value="<?php echo $Lang->loginsignup; ?>"/>

		</div>

		<div id="reset">

			<h1><?php echo $Lang->loginresetpassword; ?></h1>

			<p><a href="#" class="show-signin"><?php echo $Lang->show; ?> <?php echo $Lang->loginsignin; ?></a></p>

			<label id="reset-name"><?php echo $Lang->loginnamelabel; ?></label>
			<input type="text" name="reset-login" id="reset-name" />

			<label id="reset-email"><?php echo $Lang->email; ?></label>
			<input type="text" name="reset-email" id="reset-email" />

			<input type="submit" name="doreset" value="<?php echo $Lang->loginresetpassword; ?>"/>

		</div>

	</form>

</div>

<?php include('footer.php'); ?>