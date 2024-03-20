<?php

define("SITE_LOCAL", "www.estrutura-php.com.br");
define("SITE_HOMOLOG", "");
define("SITE_PROD", "");
define("SITE_PROD_WWW", "");

define("API_LOCAL", "");
define("API_HOMOLOG", "");
define("API_PROD", "");
define("API_PROD_WWW", "");

$appFolder = "";
$https = isHttps() ? "https://" : "http://";

$root = '';
$url_API = '';
$logCurl = '';
$showError = '';
$consoleLog = '';
$dataLayerConfig = [];
$mailConfig = [];

if ($_SERVER['SERVER_NAME'] == SITE_LOCAL) {
	$root = SITE_LOCAL;
	$url_API = API_LOCAL;

	$logCurl = TRUE;
	$consoleLog = TRUE;
	$showError = TRUE;
	require "Minify.php";

	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}
elseif ($_SERVER['SERVER_NAME'] == SITE_HOMOLOG) {
	$root = SITE_HOMOLOG;
	$url_API = API_HOMOLOG;

	$logCurl = TRUE;
	$consoleLog = TRUE;
	$showError = TRUE;

	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}
elseif ($_SERVER['SERVER_NAME'] == SITE_PROD) {
	$root = SITE_PROD;
	$url_API = API_PROD;

	$logCurl = FALSE;
	$consoleLog = FALSE;
	$showError = FALSE;

	ini_set('display_errors', 0);
	error_reporting(0);
}
elseif ($_SERVER['SERVER_NAME'] == SITE_PROD_WWW) {
	$root = SITE_PROD_WWW;
	$url_API = API_PROD_WWW;

	$logCurl = FALSE;
	$consoleLog = FALSE;
	$showError = FALSE;

	ini_set('display_errors', 0);
	error_reporting(0);
}

define("SITE", [
	"name" => "Estrutura PHP",
	"description" => "",
	"locale" => "pt_BR",
	"imageSharer" => "images/sharer.jpg",
	"root" => $https . $root . $appFolder,
	"domain" => $https . SITE_PROD,
	"cookie_expiration" => time() + 60 * 60 * 24,
	"gtmHead" => "",
	"gtmBody" => ""
]);

define("API", [
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
