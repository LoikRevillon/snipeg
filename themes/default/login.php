<?php include('header.php'); ?>

<div id="topbar"></div>

<div id="main" class="container_12">

	<form method="post" action="" id="login" autocomplete="off" class="prefix_4 grid_4">

		<div id="signin">

			<h1>Sign In</h1>

			<label for id="login-name">Your Name ( <a id="show-signup" href="#" >sign up !</a> )</label>
			<input name="login" type="text" id="login-name" autofocus />

			<label for id="login-password">Password ( <a id="show-reset" href="#">forgotten ?</a> )</label>
			<input name="password" type="password" id="login-password" />

			<input name="dologin" type="submit" value="Sign In"/>

		</div>

		<div id="signup">

			<h1>Sign Up</h1>

			<p><a href="#" class="show-signin">Show sign in</a></p>

			<label for id="signup-name">Your Name</label>
			<input name="login" type="text" id="signup-name" />

			<label for id="signup-email">Email</label>
			<input name="email" type="text" id="signup-email" />

			<label for id="signup-password-1">Password</label>
			<input name="password-1" type="password" id="signup-password-1" />

			<label for id="signup-password-2">Password ( Again )</label>
			<input name="password-2" type="password" id="signup-password-2" />
			
			<input name="dosignup" type="submit" value="Sign Up"/>

		</div>

		<div id="reset">

			<h1>Reset Password</h1>

			<p><a href="#" class="show-signin">Show sign in</a></p>

			<label for id="reset-name">Username</label>
			<input name="login" type="text" id="reset-name" />

			<label for id="reset-email">Email</label>
			<input name="email" type="text" id="reset-email" />

			<input name="doreset" type="submit" value="Reset Password"/>

		</div>

	</form>

</div>

<?php include('footer.php'); ?>