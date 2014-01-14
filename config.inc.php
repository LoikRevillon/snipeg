<?php

/*
 * General
 * -------------------------------------------------------------------------------------
*/

define('ROOT', __DIR__ . '/');
define('HTTP_SCHEME', !empty($_SERVER['HTTPS']) ? 'https' : 'http');
define('HTTP_ROOT', str_replace('index.php', '', HTTP_SCHEME . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']));
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
define('THEME_FUNCTIONS', '' ); // TODO : finish writing theme_functions.php and include it

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

/*
 * Emailing
 * -------------------------------------------------------------------------------------
*/
define('EMAIL_SENDER', 'not-reply.Snipeg@' . $_SERVER['HTTP_HOST'] );
define('EMAIL_SIGNATURE', '<br />    --------------------------------------------------    <br />    Sending by Snipeg Project, hosting by' . HTTP_ROOT );
define('EMAIL_SUBJECT', 'New password asked for your Snipeg\'s account.' );
define('EMAIL_CONTENT', 'Hello __USERNAME__.<br /><br />Snipeg can not beleive it ! ( Don\'t be surprise, Snipeg\'s living and thinking, more than talk about him to third pers. He\'s Marvin\'s cousin ;) ).<br />Really, How could you forgot it ? Shame on you.<br />Anyway, you go to be glad in addition to be thanksful, because Snipeg provide you a new password. So, stop to pray Jesus for a while, and show to his creators your plaisure to use them app, by making us a donation, just an example. c(=<br />May your admin could override this damn message.<br /><br />Your new password is the following one:<br /><strong>__NEWPASSWORD__</strong><br /><br />Please do not respond to this.<br />Over.<br />' );

/*
 * Geshi Codes
 * -------------------------------------------------------------------------------------
*/
define('GESHI_ASSOC_PATH', ROOT . 'geshi_assoc' );
