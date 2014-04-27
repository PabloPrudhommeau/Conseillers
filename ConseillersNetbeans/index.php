<?php

// Error reporting on
error_reporting(E_ALL ^ E_NOTICE);

// Charset
header('Content-Type: text/html; charset=utf-8');
// Constantes statiques
$site_path = realpath(dirname(__FILE__));
define('__SITE_PATH', $site_path);

// Constantes dynamiques
$conf_files = array_diff(scandir('config/'), array('.', '..'));
foreach ($conf_files as $val) {
	$parse = parse_ini_file('config/' . $val);
	foreach ($parse as $key => $val2) {
		define('__' . strtoupper($key), $val2);
	}
}

// Fichiers d'inclusion
$include_files = array_diff(scandir('include/'), array('.', '..'));

foreach ($include_files as $val) {
	include(__SITE_PATH . '/include/' . $val);
}

/* * * load the router ** */
$registry->router = new Router($registry);
/* * * load up the template ** */
$registry->template = new Template($registry);

$registry->router->route();

?>
