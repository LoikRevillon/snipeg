<?php

/**
 * Main configuration file
 *
 * @package base
*/

/**
 * Absolute install path
*/

define ('ROOT', __DIR__ . '/');

/**
 * Directory of themes
*/ 

define ('THEME_DIR', 'themes/');

/**
 * Absolute path of themes
*/

define ('THEME_PATH', ROOT . THEME_DIR);

/**
 * Absolute path of classes
*/

define ('CLASSES_PATH', ROOT . 'classes/');

/**
 * Relative path to languages
*/

define('LANGUAGE_DIR', 'lang/');

/**
 * Absolute path to languages
*/

define ('LANGUAGE_PATH', ROOT . LANGUAGE_DIR);

/**
 * Charset (remove it if you don't want to force charset)
*/

define ('PHP_CHARSET', 'utf-8');

/**
 * Default content of HTML <title> tag
*/

define ('DEFAULT_TITLE', '');

/**
 * Install directory URL
*/

define('HTTP_ROOT', str_replace('index.php', '', 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']));

/**
 * Default theme
*/

define('DEFAULT_THEME', 'default');

/**
 * Default language
*/

define('DEFAULT_LANG', 'en_US');

/**
 * Default number of snippets show in one page of results (paging)
*/

define('NUM_SNIPPET_ON_PAGE', 5);
