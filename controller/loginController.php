<?php
require_once 'controllerconfig.php';
session_unset();
require_once LOCATOR . '/dal/class.MySQLConnector.php';
require_once LOCATOR . '/model/class.User.php';
/**
 * the login controller is called when someone log in (obviously)
 */
// Retrieve login information from form
$username = $_POST ['username'];
$password = $_POST ['password'];

try {
	$result = validateData($username, $password);
	
	if ($result != null) {
		$_SESSION ['User'] = serialize($result);
		
		// Set the Language
		if (isset($_POST ['locale'])) {
			$_SESSION ['locale'] = $_POST ['locale'];
		}
		
		header("location: ../view/startMenu.php");
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
		
	$conn = new MySQLConnector();
	
	// check credentials
	$result = $conn->checkCredentials($GLOBALS ['username'], $GLOBALS ['password']);
	
	if (! $result)
		throw new Exception('Wrong username or password!');
	
	return $result;
}

