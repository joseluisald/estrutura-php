<?php

ini_set('display_errors', 1);
error_reporting(E_ERROR);

require dirname(__DIR__, 2) . "\\vendor\\autoload.php";

use \ScssPhp\ScssPhp\Compiler;
use \ScssPhp\ScssPhp\OutputStyle;

/**
 * @return void
 * @throws \ScssPhp\ScssPhp\Exception\SassException
 */
function compileThemesCss()
{
	$themesDir = dirname(__DIR__, 2) . "/src/";
	$themes = array_diff(scandir($themesDir), ['..', '.', 'common']);

	foreach ($themes as $theme) {
		$assetsFolder = dirname(__DIR__, 2) . "/assets/{$theme}";
		$compiler = new Compiler();
		$mapsDir = dirname(__DIR__, 2) . "/assets/{$theme}/css/maps/";
		$compiledDir = dirname(__DIR__, 2) . "/assets/{$theme}/css/";

		$compiler->setOutputStyle(OutputStyle::COMPRESSED);
		$compiler->setSourceMap(Compiler::SOURCE_MAP_FILE);

		$compiler->setSourceMapOptions([
			"sourceMapURL" => "/assets/$theme/css/maps/" . $theme . ".map",
			"sourceMapFilename" => "/assets/$theme/css/" . $theme . ".min.css",
			"sourceMapBasepath" => "/",
            "sourceRoot" => "../../assets/$theme/css/",
		]);

		$compiler->setImportPaths(dirname(__DIR__, 2) . "/src/{$theme}/scss/");
		$defaultStylesFiles = file_get_contents(dirname(__DIR__, 2) . "/src/{$theme}/scss/styles.scss");
		$compiledStyle = $compiler->compileString($defaultStylesFiles);

		if (!file_exists($assetsFolder . "/css"))
			mkdir($assetsFolder . "/css", 0777, true);

		if (!file_exists($assetsFolder . "/css/maps"))
			mkdir($assetsFolder . "/css/maps", 0777, true);

		file_put_contents($mapsDir . $theme . ".map", $compiledStyle->getSourceMap());
		file_put_contents($compiledDir . $theme . ".min.css", $compiledStyle->getCss());
	}
}

/**
 * @return void
 */
function compileCoreCss()
{
	$themesDir = dirname(__DIR__, 2) . "/src/";
	$theme = "common";

	$assetsFolder = dirname(__DIR__, 2) . "/assets/{$theme}";
	$cssPluginFolder = $themesDir . $theme . "/css";

	$cssPluginFiles = glob($cssPluginFolder . "/*/*.css");

	$cssPlugin = "";

	foreach ($cssPluginFiles as $file) {
		$cssPlugin .= file_get_contents($file);
	}

	if (!file_exists($assetsFolder . "/css"))
		mkdir($assetsFolder . "/css", 0777, true);

	$cssPluginMinifier = new \MatthiasMullie\Minify\CSS();
	$cssPluginMinifier->add($cssPlugin);
	$cssPluginMinifier->minify($assetsFolder . "/css/{$theme}.min.css");
}

/**
 * @return void
 */
function compileThemesJs()
{
	$themesDir = dirname(__DIR__, 2) . "/src/";
	$themes = array_diff(scandir($themesDir), ['..', '.', 'common']);

	foreach ($themes as $theme) {
		$assetsFolder = dirname(__DIR__, 2) . "/assets/{$theme}";
		$jsPluginFolder = $themesDir . $theme . "/js";

		$jsPluginFiles = glob($jsPluginFolder . "/custom/*.js");

        $jsPlugin = "";
		foreach ($jsPluginFiles as $file) {
            $jsPlugin .= file_get_contents($file);
		}

		if (!file_exists($assetsFolder . "/js"))
			mkdir($assetsFolder . "/js", 0777, true);

		$jsPluginMinifier = new \MatthiasMullie\Minify\JS();
		$jsPluginMinifier->add($jsPlugin);
		$jsPluginMinifier->minify($assetsFolder . "/js/{$theme}.min.js");
	}
}

/**
 * @return void
 */
function compileCoreJs()
{
    $themesDir = dirname(__DIR__, 2) . "/src/";
    $theme = "common";

    $assetsFolder = dirname(__DIR__, 2) . "/assets/{$theme}";
    $jsPluginFolder = $themesDir . $theme . "/js";

    $jsPluginFiles = glob($jsPluginFolder . "/*/*.js");

    $jsPlugin = "";
    foreach ($jsPluginFiles as $file) {
        $jsPlugin .= file_get_contents($file);
    }

    if (!file_exists($assetsFolder . "/js"))
        mkdir($assetsFolder . "/js", 0777, true);

    $jsPluginMinifier = new \MatthiasMullie\Minify\JS();
    $jsPluginMinifier->add($jsPlugin);
    $jsPluginMinifier->minify($assetsFolder . "/js/{$theme}.min.js");
}

/**
 * @return void
 * @throws \ScssPhp\ScssPhp\Exception\SassException
 */
(function () {
	compileThemesCss();
	compileCoreCss();
	compileThemesJs();
    compileCoreJs();
})();
