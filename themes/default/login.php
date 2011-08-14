<?php include('header.php'); ?>

<div id="topbar"></div>

<div id="main" class="container_12">

	<form method="post" action="" id="login" class="prefix_4 grid_4" autocomplete="off">

		<div id="signin">

			<h1>Sign In</h1>

			<label for="login-name">Your Name ( <a href="#" id="show-signup" tabindex="40">sign up !</a> )</label>
			<input type="text" name="signin-login" id="login-name" tabindex="10" autofocus />

			<label for="login-password">Password ( <a id="show-reset" href="#" tabindex="50">forgotten ?</a> )</label>
			<input type="password" name="signin-password" id="login-password" tabindex="20" />

			<input type="submit" name="dologin" value="Sign In" tabindex="30"/>

		</div>

		<div id="signup">

			<h1>Sign Up</h1>

			<p><a href="#" class="show-signin">Show sign in</a></p>

			<label id="signup-name">Your Name</label>
			<input type="text" name="signup-login" id="signup-name" />

			<label id="signup-email">Email</label>
			<input type="text" name="signup-email" id="signup-email" />

			<label id="signup-password-1">Password</label>
			<input type="password" name="signup-password-1" id="signup-password-1" />

			<label id="signup-password-2">Password ( Again )</label>
			<input type="password" name="signup-password-2" id="signup-password-2" />
			
			<input type="submit" name="dosignup" value="Sign Up"/>

		</div>

		<div id="reset">

			<h1>Reset Password</h1>

			<p><a href="#" class="show-signin">Show sign in</a></p>

			<label id="reset-name">Username</label>
			<input type="text" name="reset-login" id="reset-name" />

			<label id="reset-email">Email</label>
			<input type="text" name="reset-email" id="reset-email" />

			<input type="submit" name="doreset" value="Reset Password"/>

		</div>

	</form>

</div>

<?php include('footer.php'); ?>