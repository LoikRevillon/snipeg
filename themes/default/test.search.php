<?php

if(!empty($_GET['query'])) {

	$code1 =
"function all_settings_link() {
	add_options_page(__('All Settings'), __('All Settings'), 'administrator', 'options.php');
}

add_action('admin_menu', 'all_settings_link');";

	$code2 =
"/* Change WordPress dashboard CSS */

function custom_admin_styles() {
	echo '<style type=\"text/css\">#wphead{background:#069}</style>';
}

add_action('admin_head', 'custom_admin_styles');";

	$snippet = array();

	$snippet[] = array(
		'name'			=> 'Enable Hidden Admin Feature displaying ALL Site Settings',
		'lastUpdate'	=> 1313140553,
		'content'		=> $code1,
		'language'		=> 'php',
		'comment'		=> 'This little piece of code does something pretty cool. It will add an additional option to your settings menu with a link to "all settings".',
		'category'		=> 'Wordpress',
		'tags'			=> 'wordpress,hidden,admin,settings',
		'private'		=> 1
	);

	$snippet[] = array(
		'name'			=> 'Custom Dashboard CSS',
		'lastUpdate'	=> floor(1313140553 - rand(0, 1000)),
		'content'		=> $code2,
		'language'		=> 'php',
		'comment'		=> 'You can add any changes to the css between the tags.',
		'category'		=> 'Wordpress',
		'tags'			=> 'wordpress,css',
		'private'		=> 0
	);

	shuffle($snippet);

	echo json_encode($snippet);

}