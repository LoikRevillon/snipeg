<?php

/*
 * General
 * -------------------------------------------------------------------------------------
*/

define('ROOT', __DIR__ . '/');
define('HTTP_ROOT', str_replace('index.php', '', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']));
define('PHP_CHARSET', 'utf-8');
define('DB_NAME', ROOT . 'snipeg.sqlite');

/*
 * Themes
 * -------------------------------------------------------------------------------------
*/

define('THEME_DIR', 'themes/');
define('THEME_PATH', ROOT . THEME_DIR);

/*
 * Classes
 * -------------------------------------------------------------------------------------
*/

define('CLASSES_DIR', 'classes/');
define('CLASSES_PATH', ROOT . CLASSES_DIR);

/*
 * Languages
 * -------------------------------------------------------------------------------------
*/

define('LANGUAGE_DIR', 'lang/');
define('LANGUAGE_PATH', ROOT . LANGUAGE_DIR);
define('DEFAULT_LANG', 'en_US');

/*
 * Themes
 * -------------------------------------------------------------------------------------
*/

define('DEFAULT_THEME', 'default');

/*
 * Avatars
 * -------------------------------------------------------------------------------------
*/

define('AVATAR_DIR', 'avatars/');
define('AVATAR_WIDTH', 100);
define('AVATAR_HEIGHT', 100);
define('DEFAULT_AVATAR', AVATAR_DIR . 'avatar.png');

/*
 * Display
 * -------------------------------------------------------------------------------------
*/

define('NUM_USER_PER_PAGE', 5);
define('NUM_SNIPPET_PER_PAGE', 5);
