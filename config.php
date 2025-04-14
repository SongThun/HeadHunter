<?php
// CONFIG:
// $baseUrl: root folder

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
$host = $_SERVER['HTTP_HOST'];
$scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

$baseUrl = $protocol . $host . $scriptDir;
define('BASE_URL', $baseUrl);
define('API', $baseUrl . '/api');
define('STYLE_PATH', $baseUrl . '/css');
define('UPLOAD_IMG', $baseUrl . '/public/upload/images');
define('UPLOAD_DESC', $baseUrl . '/public/upload/descriptions');
define('UPLOAD_APP', $baseUrl . '/public/upload/applications');
define('SCRIPT_PATH', $baseUrl . '/script');

?>