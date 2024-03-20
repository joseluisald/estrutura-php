<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require dirname(__DIR__, 2) . "\\vendor\\autoload.php";

use Padaliyajay\PHPAutoprefixer\Autoprefixer;

$themesDir = dirname(__DIR__, 2) . "/assets/";
$themes = array_diff(scandir($themesDir), ['..', '.']);

foreach ($themes as $theme)
{
    $cssText = file_get_contents("{$themesDir}{$theme}/css/{$theme}.min.css");

    if ($cssText === false) {
        echo "Erro ao ler os arquivos de estilos.\n";
        exit(1);
    }

    $autoprefixer = new Autoprefixer($cssText);
    $prefixed_css = $autoprefixer->compile(false);

    file_put_contents("{$themesDir}{$theme}/css/{$theme}.prefixed.css", $prefixed_css);
}