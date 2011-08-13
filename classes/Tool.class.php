<?php

class Tool {

	public static function appendMessage ($message, $type) {

		if (!isset($_SESSION['messages']))
			$_SESSION['messages']= array();

		if (!isset($_SESSION['messages'][$type]))
			$_SESSION['messages'][$type]= array();

		$_SESSION['messages'][$type][]= $message;
		
	}

	public static function readMessages () {

		if (!empty($_SESSION['messages'])) {

			foreach($_SESSION['messages'] as $type => &$arrayMessagesByTypes) {
				echo "\n";

				foreach($arrayMessagesByTypes as $key => $message) {
					echo '<p class="' . $type . '">'.$message.'</p>'."\n";
					unset($arrayMessagesByTypes[$key]);
				}
			}
		}
	}

	public static function loadLanguage() {
		
		$actualTheme= new stdClass();
		$actualLang->name= DEFAULT_LANG;
		$haveToChangeLang= true;
			
		if (isset($_SESSION['lang'])) {
			$actualLang->name= $_SESSION['lang'];
			$haveToChangeLang= false;
		}

		if(isset($_SESSION['user'])) {
			$user= $_SESSION['user'];

			if ($actualLang->name !== $user->_language) {
				$actualLang->name= $user->_language;
				$haveToChangeLang= true;
			}
		}

		if ($haveToChangeLang) {
			$langFileJSON= file_get_contents('lang/'.$actualLang->name.'.json');
			$_SESSION['lang']= json_decode($langFileJSON, true);
		}
	}

	public static function loadTheme() {

		$actualTheme= new stdClass();
		$actualTheme->name= DEFAULT_THEME;
		$haveToChangeTheme= true;
			
		if (!empty($_SESSION['theme'])) {
			$actualTheme= $_SESSION['theme'];
			$haveToChangeTheme= false;
		}

		if(isset($_SESSION['user'])) {
			$user= $_SESSION['user'];

			if ($actualTheme->name !== $user->_theme) {
				$actualTheme->name= $user->_theme;
				$haveToChangeTheme= true;
			}
		}

		if ($haveToChangeTheme) {
			$themeFileJSON= file_get_contents('themes/' . $actualTheme->name . '/theme.json');
			$_SESSION['theme']= json_decode($themeFileJSON, true);
		}
	}

	public static function getAllThemes() {

		$themesPlace= 'themes/';
		$listOfThemes= array();
		
		foreach (glob($themesPlace.'*', GLOB_ONLYDIR | GLOB_MARK) as $themeDir) {
			var_dump($themeDir . '*.json');
			foreach (glob($themeDir . '*.json') as $themeFileJSON) {
				$content= file_get_contents($themeFileJSON);
				$listOfThemes[]= json_decode($content);
			}
		}

		return $listOfThemes;

	}

}