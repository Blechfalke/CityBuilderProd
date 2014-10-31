<?php
session_start();
// We need to define an absolute path here, because else there are problems
// referencing the classes of the GameController from different sources
define('LOCATOR', $_SERVER ['DOCUMENT_ROOT'] . '/git/CityBuilderProd');

if (isset($_SESSION ['locale'])) {
	$locale = $_SESSION ['locale'];
} else {
	$locale = "fr_CH.UTF-8";
}
putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);
bindtextdomain("test", LOCATOR . "/gettext/i18n");
textdomain("test");

ini_set("session.cookie_lifetime", "3600");

// enable debugOutput
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(- 1);
?>