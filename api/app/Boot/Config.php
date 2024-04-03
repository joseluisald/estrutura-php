<?php

define("API_LOCAL", "www.estrutura-php.com.br");
define("API_HOMOLOG", "");
define("API_PROD", "");
define("API_PROD_WWW", "");

$appFolder = "/api";
$https = isHttps() ? "https://" : "http://";

$logCurl = true;
$showError = true;

$root = '';
$dataLayerConfig = [];
$mailConfig = [];

if ($_SERVER['SERVER_NAME'] == API_LOCAL) {
	$root = API_LOCAL;
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}
elseif ($_SERVER['SERVER_NAME'] == API_HOMOLOG) {
	$root = API_HOMOLOG;
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
}
elseif ($_SERVER['SERVER_NAME'] == API_PROD) {
	$root = API_PROD;
	ini_set('display_errors', 0);
	error_reporting(0);
}
elseif ($_SERVER['SERVER_NAME'] == API_PROD_WWW) {
	$root = API_PROD_WWW;
	ini_set('display_errors', 0);
	error_reporting(0);
}

define("API", [
	"name" => "Estrutura PHP",
	"description" => "",
	"locale" => "pt_BR",
	"root" => $https . $root . $appFolder,
	"domain" => $https . API_PROD,
]);

define("LOG_CURL", $logCurl);
define("SHOW_ERROR", $showError);
define('DS', DIRECTORY_SEPARATOR);

function isHttps()
{
	return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ||
		!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https';
}
