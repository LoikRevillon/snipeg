<div id="topbar">
	<ul>
		<?php if(!empty($User)) :?> <li><?php echo htmlspecialchars(ucfirst($User->name)); ?></li>
		<li><a href="?action=new"><?php echo $Lang->menunew; ?></a></li>
		<li><a href="?action=browse"><?php echo $Lang->menubrowse; ?></a></li>
		<li><a href="?action=search"><?php echo $Lang->menusearch; ?></a></li>
		<li><a href="?action=settings"><?php echo $Lang->menusettings; ?></a></li>
		<?php if(is_admin()) : ?><li><a href="?action=admin"><?php echo $Lang->menuadmin; ?></a></li><?php endif; ?>
		<li><a href="?action=logout"><?php echo $Lang->menulogout; ?></a></li>
		<?php else :?>
		<li><a href="<?php echo HTTP_ROOT; ?>"><?php echo $Lang->menulogin; ?></a></li>
		<?php endif;?>
	</ul>
</div>
<?php Tool::readMessages();?>
