<?php

class Tool {

	public static function appendSuccess($message) {

		if (!isset($_SESSION['success']))
			$_SESSION['success']= array();

		$_SESSION['success'][]= $message;

	}

	public static function appendInfo($message) {

		if (!isset($_SESSION['info']))
			$_SESSION['info']= array();

		$_SESSION['info'][]= $message;

	}

	public static function appendWarning($message) {

		if (!isset($_SESSION['warning']))
			$_SESSION['warning']= array();

		$_SESSION['warning'][]= $message;

	}

	public static function appendError($message) {

		if (!isset($_SESSION['error']))
			$_SESSION['error']= array();

		$_SESSION['error'][]= $message;

	}

	public static function readSuccess() {

		if (isset($_SESSION['success'])) {
			foreach($_SESSION['success'] as $message) {
				echo '<p class="success">'.$message.'</p>'."\n";
				unset($message);
			}
		}
	}

	public static function readInfo() {

		if (isset($_SESSION['info'])) {
			foreach($_SESSION['info'] as $message) {
				echo '<p class="info">'.$message.'</p>'."\n";
				unset($message);
			}
		}
	}

	public static function readWarning() {

		if(isset($_SESSION['warning'])) {
			foreach($_SESSION['warning'] as $message) {
				echo '<p class="warning">'.$message.'</p>'."\n";
				unset($message);
			}
		}
	}

	public static function readError() {

		if (isset($_SESSION['error'])) {
			foreach($_SESSION['error'] as $message) {
				echo '<p class="error">'.$message.'</p>'."\n";
				unset($message);
			}
		}
	}

	public static function loadLanguage() {

		$actualLang= 'en_US';
		$haveToChangeLang= false;
			
		if (isset($_SESSION['lang'])) {
			$actualLang= $_SESSION['lang'];
		}

		if(isset($_SESSION['user'])) {
			$user= $_SESSION['user'];

			if ($actualLang->name !== $user->_language) {
				$actualLang= $user->_language;
				$haveToChangeLang= true;
			}
		}

		if ($haveToChangeLang) {
			$langFileJSON= file_get_contents('lang/'.$actualLang->name.'.json');
			$_SESSION['lang']= json_decode($langFileJSON);
		}
	}

	public static function loadTheme() {

		$actualTheme= 'default';
		$haveToChangeTheme= false;
			
		if (isset($_SESSION['theme'])) {
			$actualTheme= $_SESSION['theme'];
		}

		if(isset($_SESSION['user'])) {
			$user= $_SESSION['user'];

			if ($actualTheme->name !== $user->_theme) {
				$actualLang= $user->_theme;
				$haveToChangeTheme= true;
			}
		}

		if ($haveToChangeTheme) {
			$themeFileJSON= file_get_contents('theme/'.$actualTheme->name.'.json');
			$_SESSION['theme']= json_decode($themeFileJSON, true);
		}

		foreach ($_SESSION['theme'] as $key => $value) {
			
			switch($key) {
				
				case 'css':
				case 'CSS':
				case 'style sheet':
				case 'Style Sheet':
				case 'style':
				case 'Style':
					echo '<link rel="stylesheet" type="text/css" href="' . 'theme/' . $actualTheme->name . '/style/' . $value . '.css" />';
				break;
				
				case 'js':
				case 'JS':
				case 'javascript':
				case 'Javascript':
					echo '<script type="application/javascript" src="' . 'theme/' . $actualTheme->name . '/js/' . $value . '.js"></script>';
				break;
			}
		}				
	}

	public static function searchInSnippets($name) {

		if (isset($_SESSION['user'])) {
			$user= $_SESSION['user'];
			$manager= new UserManager::getReference();

			return $manager->getSnippetsMatchedByName($user->_id, $name);
		}

		return false;
	}

}