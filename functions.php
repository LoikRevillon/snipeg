<?php

	function __autoload($className) {
		$classPath= 'classes/'.$className.'.class.php';
		require ($classPath);
	}

	function loadLanguage() {
		$default= 'en_US';
			
		if (isset($_SESSION['lang'])) {
			$actualLang= $_SESSION['lang'];

			if(isset($_SESSION['user'])) {
				$user= $_SESSION['user'];

				if ($actualLang->name !== $user->_language) {
					$langFileJSON= file_get_contents('lang/'.$actualLang->name.'json');
					$_SESSION['lang']= json_decode($langFileJSON);
					return true
				}
			}
		}
		$langFileJSON= file_get_contents('lang/'.$default.'.json');
		$_SESSION['lang']= json_decode($langFileJSON);
		return true;
	}				