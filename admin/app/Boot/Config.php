<?php

define("ADMIN_LOCAL", "www.estrutura-php.com.br");
define("ADMIN_HOMOLOG", "");
define("ADMIN_PROD", "");
define("ADMIN_PROD_WWW", "");

define("API_ADMIN_LOCAL", "");
define("API_ADMIN_HOMOLOG", "");
define("API_ADMIN_PROD", "");
define("API_ADMIN_PROD_WWW", "");

$appFolder = "/admin";
$https = isHttps() ? "https://" : "http://";

$root = '';
$url_API = '';
$logCurl = '';
$showError = '';
$consoleLog = '';
$dataLayerConfig = [];
$mailConfig = [];

if ($_SERVER['SERVER_NAME'] == ADMIN_LOCAL) {
	$root = ADMIN_LOCAL;
	$url_API = API_ADMIN_LOCAL;

	$logCurl = TRUE;
	$consoleLog = TRUE;
	$showError = TRUE;
	require "Minify.php";

	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}
elseif ($_SERVER['SERVER_NAME'] == ADMIN_HOMOLOG) {
	$root = ADMIN_HOMOLOG;
	$url_API = API_ADMIN_HOMOLOG;

	$logCurl = TRUE;
	$consoleLog = TRUE;
	$showError = TRUE;

	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}
elseif ($_SERVER['SERVER_NAME'] == ADMIN_PROD) {
	$root = ADMIN_PROD;
	$url_API = API_ADMIN_PROD;

	$logCurl = FALSE;
	$consoleLog = FALSE;
	$showError = FALSE;

	ini_set('display_errors', 0);
	error_reporting(0);
}
elseif ($_SERVER['SERVER_NAME'] == ADMIN_PROD_WWW) {
	$root = ADMIN_PROD_WWW;
	$url_API = API_ADMIN_PROD_WWW;

	$logCurl = FALSE;
	$consoleLog = FALSE;
	$showError = FALSE;

	ini_set('display_errors', 0);
	error_reporting(0);
}

define("ADMIN", [
	"name" => "Estrutura PHP",
	"description" => "",
	"locale" => "pt_BR",
	"imageSharer" => "images/sharer.jpg",
	"root" => $https . $root . $appFolder,
	"domain" => $https . ADMIN_PROD,
	"cookie_expiration" => time() + 60 * 60 * 24,
	"gtmHead" => "",
	"gtmBody" => ""
]);

define("API_ADMIN", [
	"url" => $https . $url_API,
]);

define("LOG_CURL", $logCurl);
define("SHOW_ERROR", $showError);
define("CONSOLE_LOG", $consoleLog);
define('DS', DIRECTORY_SEPARATOR);

function isHttps()
{
	return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ||
		!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https';
}
