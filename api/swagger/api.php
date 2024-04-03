<?php
	
	require dirname(__DIR__, 1) . "/vendor/autoload.php";
	
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	$openapi = \OpenApi\Generator::scan([dirname(__FILE__, 2) . DS .'app'. DS .'Controllers' . DS . 'Api']);
	
	header('Content-Type: application/json');
	echo $openapi->toJSON();