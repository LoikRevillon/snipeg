<?php

$css = array(
	'jquery-1.6.2.min.js',
	'less-1.1.3.min.js'
);

$output = '';

foreach($css AS $filename) {
	$output .= file_get_contents($filename) . "\n\n";
}

header('Content-type: text/javascript; charset=utf-8');

echo $output;