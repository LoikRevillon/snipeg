<?php

class Tool {

	const M_ERROR = 'error';

	const M_INFO = 'info';

	const M_SUCCESS = 'success';

	const M_WARNING = 'warning';

	public static function preload() {

		session_start();

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
					echo '<p class="' . htmlspecialchars($type) . '">' . htmlspecialchars($message) . '</p>';
					unset($messages[$index]);
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

	public static function emailExistInDB($email) {

		try {

			$db = PDOSQLite::getDBLink();
			$request = $db->prepare('SELECT * FROM `users` WHERE `email` = :email');
			$request->bindValue(':email', $email, PDO::PARAM_STR);

			return $request->execute();

		} catch (Exception$e) {
			return false;
		}
	}

	public static function loadLanguage() {

		global $Theme;

		if ( isset ( $_SESSION['user'] ) )
			$shownLang = $_SESSION['user']->_language;

		$langCode = ( !empty( $shownLang ) ) ? $_SESSION['user']->_language : DEFAULT_LANG;

		if(!empty($_SESSION['lang'])) {
			if(!empty($_SESSION['user']) AND $_SESSION['user']->_language == $_SESSION['lang']->langcode) {
				return $_SESSION['lang'];
			}
		}

		$_SESSION['lang'] = new stdClass();
		$themeLangFile = THEME_PATH . $Theme->dirname . '/' . LANGUAGE_DIR .  $langCode . '.json';
		$globalLangFile = LANGUAGE_PATH . $langCode . '.json';

		if(file_exists($globalLangFile)) {
			$globalLang = json_decode(file_get_contents($globalLangFile));
		} else {
			$globalLang = json_decode(file_get_contents(LANGUAGE_PATH . DEFAULT_LANG .'.json'));
			self::appendMessage($globalLang->info_fallback_used, self::M_INFO);
		}

		if(file_exists($themeLangFile)) {
			$themeLang = json_decode(file_get_contents($themeLangFile));
			$Composer = new Compositor($globalLang, $themeLang);
			$_SESSION['lang'] = $Composer;
		} else {
			$_SESSION['lang'] = $globalLang;
		}

		$_SESSION['lang']->langcode = $langCode;

		return $_SESSION['lang'];

	}

	public static function loadTheme() {

		$dirname = !empty($_SESSION['user']->_theme) ? $_SESSION['user']->_theme : DEFAULT_THEME;

		if(!empty($_SESSION['theme']->dirname)) {
			if(!isset($_SESSION['user'])
				OR (isset($_SESSION['theme']->dirname) AND $_SESSION['user']->theme == $_SESSION['theme']->dirname)) {
				return $_SESSION['theme'];
			}
		}

		$_SESSION['theme'] = new stdClass();
		$themeFile = THEME_PATH . $dirname . '/theme.json';

		if(file_exists($themeFile)) {
			$_SESSION['theme'] = json_decode(file_get_contents($themeFile));
			$_SESSION['theme']->dirname = $dirname;
			$_SESSION['theme']->location = HTTP_ROOT . THEME_DIR . urlencode($_SESSION['theme']->dirname) . '/';
		}

		return $_SESSION['theme'];

	}

	public static function loadGeshiCodes() {

		$geshi_assoc = file_get_contents( GESHI_ASSOC_PATH );

		return explode( ',', $geshi_assoc );
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

	public static function getAllLangs() {

		if (empty($_SESSION['user']))
			return false;

		$langDir = THEME_PATH . $_SESSION['user']->_theme . '/' . LANGUAGE_DIR;
		$listOfLangs = array();

		foreach(glob($langDir . '*.json') as $langFileJSON) {
			$content = file_get_contents($langFileJSON);
			$decodeContent = json_decode($content);
			$decodeContent->filename = pathinfo($langFileJSON, PATHINFO_FILENAME);
			$listOfLangs[] = $decodeContent;
		}

		return $listOfLangs;

	}

	public static function linkify($string, $newtab = true) {

		if($newtab)
			return preg_replace('!(http://[a-z0-9_./?=&-]+)!i', '<a href="$1" onclick="window.open(this.href); return false;">$1</a> ', $string . ' ');
		else
			return preg_replace('!(http://[a-z0-9_./?=&-]+)!i', '<a href="$1">$1</a> ', $string . ' ');

	}
}
