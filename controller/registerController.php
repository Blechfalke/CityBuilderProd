<?php
require_once 'controllerconfig.php';
require_once LOCATOR . '/dal/class.MySQLConnector.php';
require_once LOCATOR . '/model/class.User.php';

/**
 * 
 * the register controller is used to handle the logic behind the registration (password check, database check, database storing)
 * 
 */

$username = $_POST ['username'];
$password = $_POST ['password'];
$repassword = $_POST ['repassword'];

$conn = new MySQLConnector();

try {
	if (strlen($username) < 3) {
		throw new Exception('Username has to be at least 3 Characters');
	}
	
	// First check, if the user exists
	$result = $conn->getIdByUsername($GLOBALS ['username']);
	
	// If we receive no result, the username does not exist yet
	if ($result)
		throw new Exception('Username already taken!');
	
	if ($password != $repassword)
		throw new Exception('Passwords do not match!');
	
	if ($password == '')
		throw new Exception('Please define a password!');
	
	// Create the User in the database
	$result = $conn->createUser($username, $password);
	
	if ($result) {
		$msg = 'User created';
	}else{
		$msg = 'Error creating the User';
	}
} catch (Exception $e) {
	$msg = $e->getMessage();
}
// Redirect to the same page and display the errormsg
header("location:../view/register.php?msgRegister=$msg&username=$username");