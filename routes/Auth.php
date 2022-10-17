<?php

$app = require_once 'config/app.php';
$db = require_once 'config/database.php';

$base = (
	isset($_SERVER['REQUEST_SCHEME']) && isset($_SERVER['SERVER_NAME']) && $_SERVER['REQUEST_SCHEME'] == "http" ?
	"http://".$_SERVER['SERVER_NAME']:
	isset($_SERVER['REQUEST_SCHEME']) && isset($_SERVER['SERVER_NAME']) && $_SERVER['REQUEST_SCHEME'] == "https" ?
	"http://".$_SERVER['SERVER_NAME']:
	$app['url']
)."/pemiralp3i.or.id";

if (isset($_SERVER['SERVER_NAME']) && strpos($app['url'], $_SERVER['SERVER_NAME'])) $base = $app['url'];

define('DB_HOST', $db['db_host']);
define('DB_USER', $db['db_user']);
define('DB_PASS', $db['db_pass']);
define('DB_NAME', $db['db_name']);
define("BASE_URL", $base);