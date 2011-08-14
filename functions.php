<?php

function __autoload($className) {

	$classPath = 'classes/' . $className . '.class.php';

	if (file_exists($classPath))
		require ($classPath);

}

function theme_root() {

	echo HTTP_ROOT . THEME_DIR . $_SESSION['theme']['dirName'] . '/';

}
