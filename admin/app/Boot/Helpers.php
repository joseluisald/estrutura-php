<?php

use App\Supports\Image;
use MatthiasMullie\Minify\JS;
use ScssPhp\ScssPhp\Compiler;
use ScssPhp\ScssPhp\OutputStyle;

/**
 * @param string|null $param
 * @return string
 */
function admin(string $param = null): string
{
	if ($param && !empty(ADMIN[$param]))
		return ADMIN[$param];

	return ADMIN["root"];
}

/**
 * @param string|null $param
 * @return string
 */
function apiAdmin(string $param = null): string
{
	if ($param && !empty(API_ADMIN[$param]))
		return API_ADMIN[$param];

	return API_ADMIN["url"];
}

/**
 * @param $image
 * @return string
 */
function bannerImage($image)
{
	return API_ADMIN["url"] . '/assets/uploads/banners/'.$image;
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
 * @param $size
 * @param $text
 * @return string
 */
function placeholder($size, $text = null)
{
	if (!is_null($text)) {
		return "https://placehold.co/{$size}?text={$text}";
	}
	return "https://placehold.co/{$size}";
}

/**
 * @param string $theme
 * @param string $path
 * @param bool $time
 * @param bool $returnPath
 * @return string
 */
function asset(string $theme, string $path, bool $time = true, bool $returnPath = false): string
{
	$file = ADMIN["root"] . "/assets/{$theme}/{$path}";
	$fileOnDir = dirname(__DIR__, 2) . "/assets/{$theme}/{$path}";
	if ($time && file_exists($fileOnDir) && $_SERVER['SERVER_NAME'] != ADMIN_PROD) {
		$file .= "?time=" . filemtime($fileOnDir);
	}

	return ($returnPath == true) ? $fileOnDir : $file;
	// return $file;
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
	echo "<pre>";

	if ($dump == true)
		var_dump($data);
	else
		print_r($data);

	echo "</pre>";
	echo "<hr>";
	if ($die) die();
}

/**
 * @param $value
 * @param $showCurrency
 * @return string|null
 */
function printMoney($value = 0, $showCurrency = false)
{
	if(!empty($value)) {
		$currency = $showCurrency == true ? "R$ " : "";
		return $currency . number_format($value, 2, ',', '.');
	}
	return null;
}

/**
 * @param $date
 * @param $printTime
 * @return false|string
 */
function printDate($date, $printTime = true)
{
	if(!empty($date)) {
		$date = date_create($date);
		return $printTime == true ? date_format($date, 'd/m/Y') . " às " . date_format($date, 'H:i') : date_format($date, 'd/m/Y');
	}
	
	return null;
}

/**
 * @param string|null $type
 * @param string|null $message
 * @return string|null
 */
function flash(string $type = null, string $message = null): ?string
{
	if ($type && $message) {
		$_SESSION["flash"] = [
			"type" => $type,
			"message" => $message
		];

		return null;
	}

	if (!empty($_SESSION["flash"]) && $flash = $_SESSION["flash"]) {
		unset($_SESSION["flash"]);
		return "<script>Swal.fire({icon: '{$flash["type"]}', title: '{$flash["message"]}',showConfirmButton: false, timer: 2500});</script>";
	}

	return null;
}

/**
 * @param $pages
 * @param $currentPage
 * @return string
 */
function activeMenu($pages, $currentPage)
{
	if (!is_array($pages)) {
		$pages = [$pages];
	}

	if (in_array($currentPage, $pages)) {
		return 'active';
	}
	return '';
}

/**
 * @param string $theme
 * @param string $page
 * @return string
 * @throws \ScssPhp\ScssPhp\Exception\SassException
 */
function getCSS(string $theme, string $page): string
{
	try {
		if ($_SERVER['SERVER_NAME'] == ADMIN_LOCAL && file_exists(dirname(__DIR__, 2) . "/src/$theme/scss/pages/" . $page . ".scss")) {

			$srcFolder = dirname(__DIR__, 2) . "/src/$theme/";

			$compiler = new Compiler();

			$compiledDir = dirname(__DIR__, 2) . "/assets/$theme/css/pages/";
			$mapsDir = $compiledDir . "/maps/";

			if (!file_exists($compiledDir)) {
				mkdir($compiledDir, 0777, true);
			}

			if (!file_exists($mapsDir)) {
				mkdir($mapsDir, 0777, true);
			}

			$compiler->setOutputStyle(OutputStyle::COMPRESSED);
			$compiler->setSourceMap(Compiler::SOURCE_MAP_FILE);

			$compiler->setSourceMapOptions([
				"sourceMapURL" => "/assets/$theme/css/pages/maps/" . $page . ".map",
				"sourceMapFilename" => "/assets/$theme/css/pages/" . $page . ".min.css",
				"sourceMapBasepath" => "/",
				'sourceRoot' => "../../assets/$theme/css/pages/",
			]);
			$compiler->setImportPaths($srcFolder . "scss/pages/");
			$compiledStyle = $compiler->compileString('@import "' . $page . '.scss";');

			file_put_contents($mapsDir . $page . ".map", $compiledStyle->getSourceMap());
			file_put_contents($compiledDir . $page . ".min.css", $compiledStyle->getCss());
		}

		if (!file_exists(dirname(__DIR__, 2) . "/assets/$theme/css/pages/" . $page . ".min.css")) {
			syslog(LOG_ERR, $page . ".min.css" . ' não localizado');
		}

		return $page . ".min.css";
	} catch (\Exception $e) {
		echo '';
		syslog(LOG_ERR, 'scssphp: Unable to compile content');
	}

	return "";
}

/**
 * @param string $theme
 * @param string $page
 * @return string
 */
function getJS(string $theme, string $page): string
{
	if ($_SERVER['SERVER_NAME'] == ADMIN_LOCAL && file_exists(dirname(__DIR__, 2) . "/src/$theme/js/pages/" . $page . ".js")) {
		$compiler = new JS();

		$compiledDir = dirname(__DIR__, 2) . "/assets/$theme/js/pages/";
		$srcFolder = dirname(__DIR__, 2) . "/src/$theme/js/pages/";

		if (!file_exists($compiledDir)) {
			mkdir($compiledDir, 0777, true);
		}

		$compiler->add(file_get_contents($srcFolder . "$page.js"));
		$compiler->minify($compiledDir . $page . ".min.js");
	}

	if (!file_exists(dirname(__DIR__, 2) . "/assets/$theme/js/pages/" . $page . ".min.js")) {
		return "";
	}

	return $page . ".min.js";
}

/**
 * @return mixed
 */
function addBreadcrumb()
{
	$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	$paths = explode("/", strtok(substr($_SERVER["REQUEST_URI"], 1), "?"));

	$formattedPathTitle = ucwords(str_replace('-', ' ', $paths[1]));
	$formattedPathTitle = $formattedPathTitle == 'Admin' || empty($formattedPathTitle) ? 'Dashboard' : $formattedPathTitle;

	$breadcrumbHtml = '<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">' . $formattedPathTitle . '</h1>';
	$breadcrumbHtml .= '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">';

	$urlSoFar = $currentUrl;

	foreach ($paths as $index => $path) {
		$urlSoFar .= '/' . $path;
		$breadcrumbHtml .= '<li class="breadcrumb-item';

		$formattedPath = ucwords(str_replace('-', ' ', $path));

		if ($index < count($paths) - 1) {

			$formattedPath = $formattedPath == 'Admin' ? 'Dashboard' : $formattedPath;

			$breadcrumbHtml .= '">
                <a href="' . $urlSoFar . '"
                   class="text-muted text-hover-primary">' . $formattedPath . '</a>
            </li>
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li>';
		} else {
			$breadcrumbHtml .= ' text-muted">' . $formattedPath . '</li>';
		}
	}

	$breadcrumbHtml .= '</ul>';

	return $breadcrumbHtml;
}

/**
 * @param $router
 * @param $breadcrumbs
 * @return string
 */
function breadcrumb($router, $breadcrumbs): string
{
	$html = '<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">'.@$breadcrumbs[0][0].'</h1>';
	$html .= '<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">';
	$html .= '<li class="breadcrumb-item"><a href="' . $router->route('admin.index') . '" class="text-muted text-hover-primary">Dashboard</a></li>';
	$html .= '<li class="breadcrumb-item"><span class="bullet bg-gray-400 w-5px h-2px"></span></li>';
	$totalItems = count($breadcrumbs);
	if ($totalItems > 0) {
		foreach ($breadcrumbs as $index => $breadcrumb) {
			if ($index > 0) {
				$html .= '<li class="breadcrumb-item"><span class="bullet bg-gray-400 w-5px h-2px"></span></li>';
			}
			$html .= '<li class="breadcrumb-item">';
			if (isset($breadcrumb[1])) {
				$html .= '<a href="' . $router->route($breadcrumb[1]) . '" class="text-muted text-hover-primary">' . $breadcrumb[0] . '</a>';
			} else {
				$html .= '<span class="text-muted">' . $breadcrumb[0] . '</span>';
			}
			$html .= '</li>';
		}
	}
	$html .= '</ul>';
	
	return $html;
}

/**
 * @param $refer1
 * @param $refer2
 * @return string
 */
function optionSelected($refer1, $refer2)
{
	return $refer1 == $refer2 ? 'selected' : '';
}

/**
 * @param $refer1
 * @param $refer2
 * @return string
 */
function isActive($refer1, $refer2)
{
    return $refer1 == $refer2 ? 'active' : '';
}

/**
 * @param $refer1
 * @return string
 */
function inputChecked($refer1)
{
	return $refer1 ? 'checked="checked"' : '';
}

/**
 * @param $attachment
 * @param $theme
 * @return string
 */
function getFileIcon($attachment, $theme)
{
	$fileExtension = 'generic.png';
	$attachmentExtension = pathinfo($attachment, PATHINFO_EXTENSION);

	$assetDir = ADMIN["root"] . "/assets/{$theme}/images/file-icons/";
	$fileIconsDir = dirname(__DIR__, 2) . "/assets/{$theme}/images/file-icons/";
	$availableExtensions = [];

	$files = glob($fileIconsDir . '*.{png,jpg,jpeg,svg}', GLOB_BRACE);
	foreach ($files as $file) {
		$extension = pathinfo($file, PATHINFO_FILENAME);
		$availableExtensions[] = $extension;
	}

	if (in_array(trim($attachmentExtension), $availableExtensions)) {
		$fileExtension = $attachmentExtension . '.png';
	}

	$iconPath = $assetDir . $fileExtension;

	return $iconPath;
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