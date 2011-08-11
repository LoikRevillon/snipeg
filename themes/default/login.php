<?php include('header.php'); ?>

<div id="topbar"></div>

<div id="main" class="container_12">
	<form method="post" action="" id="login" autocomplete="off" class="prefix_4 grid_4">
		<h1>Sign In</h1>
		<label for id="login-name">Your Name ( <a href="#">sign up !</a> )</label>
		<input name="login" type="text" id="login-name" autofocus/>
		<label for id="login-password">Password ( <a href="#">forgotten ?</a> )</label>
		<input name="password" type="password" id="login-password" />
		<input type="submit" value="Sign In"/>
	</form>
</div>

<?php include('footer.php'); ?>