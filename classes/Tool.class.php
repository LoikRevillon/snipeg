<?php

class Tool {

	const M_ERROR = 'error';

	const M_INFO = 'info';

	const M_SUCCESS = 'success';

	const M_WARNING = 'warning';

	public static function preload() {

		if(!isset($_SESSION['messages']))
			$_SESSION['messages'] = array();

	}

	public static function appendMessage($message, $type) {

		if(!isset($_SESSION['messages'][$type]))
			$_SESSION['messages'][$type] = array();
		$_SESSION['messages'][$type][] = $message;

	}

	public static function readMessages() {

		if(!empty($_SESSION['messages'])) {
			foreach($_SESSION['messages'] as $type => &$messages) {
				foreach($messages as $index => $message) {
					echo '<p class="' . $type . '">' . $message . '</p>';
					unset($messages[$key]);
				}
			}
		}

	}

	public static function generatePassword($length) {

		$password = '';
		$vowels = 'aeuyAEUY';
		$consonants = 'bdghjmnpqrstvzBDGHJLMNPQRSTVWXZ23456789';

		for($i = 0; $i < $length; $i++) {

			if($i % 2)
				$password .= $consonants[(rand() % strlen($consonants))];
			else
				$password .= $vowels[(rand() % strlen($vowels))];

		}

		return $password;

	}

	public static function loadLanguage() {

		$langCode = !empty($_SESSION['user']->_language) ? $_SESSION['user']->_language : DEFAULT_LANG;

		if(!empty($_SESSION['lang']->langcode)) {
			if(!isset($_SESSION['user'])
				OR (isset($_SESSION['user']->_language) AND $_SESSION['user']->_language == $_SESSION['lang']->langcode)) {
				return $_SESSION['lang'];
			}
		}

		$_SESSION['lang'] = new stdClass();
		$langFile = LANGUAGE_PATH . $langCode . '.json';

		if(file_exists($langFile)) {
			$_SESSION['lang'] = json_decode(file_get_contents($langFile));
			$_SESSION['lang']->langcode = $langCode;
		}

		return $_SESSION['lang'];

	}

	public static function loadTheme() {

		$dirname = !empty($_SESSION['user']->_theme) ? $_SESSION['user']->_theme : DEFAULT_THEME;

		if(!empty($_SESSION['theme']->dirname)) {
			if(!isset($_SESSION['user'])
				OR (isset($_SESSION['theme']->dirname) AND $_SESSION['user']->dirname == $_SESSION['theme']->dirname)) {
				return $_SESSION['theme'];
			}
		}

		$_SESSION['theme'] = new stdClass();
		$themeFile = THEME_PATH . $dirname . '/theme.json';

		if(file_exists($themeFile)) {
			$_SESSION['theme'] = json_decode(file_get_contents($themeFile));
			$_SESSION['theme']->dirname = $dirname;
			$_SESSION['theme']->location = HTTP_ROOT . THEME_DIR . $_SESSION['theme']->dirname . '/';
		}

		return $_SESSION['theme'];

	}

	public static function getAllThemes() {

		$themesPlace = THEME_PATH;
		$listOfThemes = array();

		foreach(glob($themesPlace . '*', GLOB_ONLYDIR | GLOB_MARK) as $themeDir) {
			foreach(glob($themeDir . '*.json') as $themeFileJSON) {
				$content = file_get_contents($themeFileJSON);
				$decodeContent = json_decode($content);
				$decodeContent->dirname = end(explode('/', substr($themeDir, 0, -1)));
				$listOfThemes[] = $decodeContent;
			}
		}

		return $listOfThemes;

	}

}