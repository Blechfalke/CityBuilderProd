<?php
// We need to define an absolute path here, because else there are problems
// referencing the classes of the GameController from different sources
define('LOCATOR', $_SERVER['DOCUMENT_ROOT'] . '/git/CityBuilderProd');

// enable debugOutput
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
?>