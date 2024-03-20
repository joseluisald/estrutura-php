<?php
header('Set-Cookie: AdminGelatoBorelli=true; SameSite=None;Secure');
header("Cache-Control: private, max-age=10800, pre-check=10800");
header("Pragma: private");

if (isset($_SERVER['HTTP_ORIGIN'])) {
	header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
}

ob_start();
if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}

require __DIR__ . "/vendor/autoload.php";

// set_error_handler("errorsHandler");

use CoffeeCode\Router\Router;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

date_default_timezone_set('America/Sao_Paulo');

$router = new Router(site());
$router->namespace("App\Controllers");

include 'app/Routes/Routes.php';

$router->dispatch();

if ($router->error() && SHOW_ERROR) {
	if (substr($_SERVER["REQUEST_URI"], -1) == '/') {
		header("Location: " . rtrim($_SERVER["REQUEST_URI"], '/'), TRUE, 301);
		die;
	}

	$log = new Logger("url");
	$log->pushHandler(new StreamHandler('./logs/router_log/log_ ' . date("Y-m-d") . ' .txt', Logger::ERROR));

	$log->error("REQUEST_URI = " . @$_SERVER["REQUEST_URI"]);
	$log->error("HTTP_REFERER = " . @$_SERVER["HTTP_REFERER"]);

	$router->redirect("error.error", ["errcode" => $router->error()]);
}

ob_end_flush();
