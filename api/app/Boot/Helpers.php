<?php

use MatthiasMullie\Minify\JS;
use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\OutputStyle;

/**
 * @param string|null $param
 * @return string
 */
function api(string $param = null): string
{
	if ($param && !empty(API[$param]))
		return API[$param];

	return API["root"];
}

/**
 * @return array
 */
function extractParamUrl(): stdClass
{
	$url = $_SERVER['REQUEST_URI'];
	$parsedUrl = parse_url($url);

	if (isset($parsedUrl['path'])) {
		$path = trim($parsedUrl['path'], '/');
		$params = explode('/', $path);
		return (object) $params;
	} else {
		return [];
	}
}

/**
 * @return string
 */
function getFirstPathUrl()
{
	$paths = explode("/", strtok(substr($_SERVER["REQUEST_URI"], 1), "?"));
	return empty($paths[1]) ? null : ucwords(str_replace('-', ' ', $paths[1]));
}

/**
 * @param $error
 * @param $message
 * @param $file
 * @param $line
 * @return void
 */
function errorsHandler($error, $message, $file, $line)
{
	$color = ($error == E_USER_ERROR ? "fsred" : "fsyellow");
	echo "<div class='trigger' style='border-color: var(--{$color}); color:var(--{$color});'>[ Linha {$line} ] {$message} <small>{$file}</small></div>";
}

/**
 * @param $data
 * @param bool $dump
 * @return void
 */
function debug($data, bool $dump = false, bool $die = true): void
{
	if ($dump == true)
		var_dump($data);
	else
		print_r($data);
	
	if ($die) die();
}

/**
 * @param $param
 * @return void
 */
function redirect($param)
{
	header("Location: $param");
	exit;
}

/**
 * @return mixed
 */
function getMyIP()
{
    return $_SERVER['REMOTE_ADDR'];
}

/**
 * @param $email
 * @return void
 */
function validateEmail($email)
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo("$email is a valid email address");
    } else {
        echo("$email is not a valid email address");
    }
}

/**
 * @param $doc
 * @return array|string|string[]
 */
function clearCpf($doc)
{
    $doc = trim($doc);
    $doc = str_replace(".", "", $doc);
    $doc = str_replace(",", "", $doc);
    $doc = str_replace("-", "", $doc);
    $doc = str_replace("/", "", $doc);
    return $doc;
}

/**
 * @param $doc
 * @return array|string|string[]
 */
function clearPhone($doc)
{
    $doc = trim($doc);
    $doc = str_replace(" ", "", $doc);
    $doc = str_replace("(", "", $doc);
    $doc = str_replace(")", "", $doc);
    $doc = str_replace("-", "", $doc);
    return $doc;
}

/**
 * @param $number
 * @return array
 */
function codePhone($number)
{
    $phone 			= clearPhone($number);
    $PhoneCode 		= preg_replace('/\A.{2}?\K[\d]+/', '', $phone);
    $PhoneNumber 	= preg_replace('/^\d{2}/', '', $phone);
    return ['PhoneCode' => $PhoneCode, 'PhoneNumber' => $PhoneNumber];
}

/**
 * @param $data
 * @return string
 */
function clearDate($data)
{
    list($moth, $yaer) = explode(" / ", $data);
    $moth = trim($moth);
    $yaer = trim($yaer);
    return "$moth/$yaer";
}

/**
 * @param $value
 * @return mixed
 */
function sanitizeInt($value)
{
    return filter_var(preg_replace("/[^0-9]/", "", $value), FILTER_SANITIZE_NUMBER_INT);
}

/**
 * @param $cpf_cnpj
 * @return string|null
 */
function formatDocument($cpf_cnpj)
{
	if(!empty($cpf_cnpj)) {
		$cpf_cnpj = preg_replace('/[^0-9]/', '', $cpf_cnpj);
		
		if (strlen($cpf_cnpj) === 11) {
			return substr($cpf_cnpj, 0, 3) . '.' . substr($cpf_cnpj, 3, 3) . '.' . substr($cpf_cnpj, 6, 3) . '-' . substr($cpf_cnpj, 9, 2);
		} elseif (strlen($cpf_cnpj) === 14) {
			return substr($cpf_cnpj, 0, 2) . '.' . substr($cpf_cnpj, 2, 3) . '.' . substr($cpf_cnpj, 5, 3) . '/' . substr($cpf_cnpj, 8, 4) . '-' . substr($cpf_cnpj, 12, 2);
		} else {
			return $cpf_cnpj;
		}
	}
	return null;
}

/**
 * @param $phone_number
 * @return string|null
 */
function formatPhoneNumber($phone_number)
{
	if(!empty($phone_number)) {
		$phone_number = preg_replace('/[^0-9]/', '', $phone_number);
		
		if (strlen($phone_number) === 11) {
			return '(' . substr($phone_number, 0, 2) . ') ' . substr($phone_number, 2, 1) . ' ' . substr($phone_number, 3, 4) . '-' . substr($phone_number, 7);
		} elseif (strlen($phone_number) === 10) {
			return '(' . substr($phone_number, 0, 2) . ') ' . substr($phone_number, 2, 4) . '-' . substr($phone_number, 6);
		} else {
			return $phone_number;
		}
	}
	return null;
}