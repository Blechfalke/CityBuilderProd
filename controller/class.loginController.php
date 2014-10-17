<?php
session_start();
session_unset();
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/git/CityBuilderProd/config.php');
require_once LOCATOR . '/dal/class.MySQLConnector.php';
require_once LOCATOR . '/model/class.User.php';

// Retrieve login information from form
$username = $_POST ['username'];
$password = $_POST ['password'];

try {
	$result = validateData($username, $password);
	
	if ($result != null) {
		$_SESSION ['User'] = serialize($result);
		
		header("location: ../view/startMenu.php");
		exit();
	}
} catch (Exception $e) {
	$_SESSION ['msg'] = $e->getMessage();
	header('location:../view/login.php');
	exit();
}

function validateData() {
	if (empty($GLOBALS ['username']))
		throw new Exception('Username is empty!');
	
	if (empty($GLOBALS ['password']))
		throw new Exception('Password is empty!');
		
		// check credentials
	$conn = new MySQLConnector();
	
	$result = $conn->checkCredentials($GLOBALS ['username'], $GLOBALS ['password']);
	
	if (! $result)
		throw new Exception('Wrong username or password!');
	
	return $result;
}

