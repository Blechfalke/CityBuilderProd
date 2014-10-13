<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/git/CityBuilderProd/config.php');
require_once LOCATOR . '/dal/class.MySQLConnector.php';

$newGameMode = isset($_POST ['newMode']) ? $_POST ['newMode'] : 0;

if ($newGameMode != 0) {
	$conn = new MySQLConnector();
	
	$conn->setGameMode($newGameMode);
}
header("location: ../view/startMenu.php");

?>