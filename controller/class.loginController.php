<?php

require_once '../dal/class.MySQLConnector.php';

// Retrieve login information from form
$username = $_POST ['Username'];
$password = $_POST ['Password'];

try {
	$result = validateData ( $username, $password );
	echo 'Hello ' . $result->username;
} catch ( Exception $e ) {
	header ( 'Location:../index.php?msg=' . $e->getMessage() );
	exit ();
}

function validateData() {
	if (empty ($GLOBALS['username']))
		throw new Exception ( 'Username is empty!' );
	
	if (empty ( $GLOBALS['password'] )) 
		throw new Exception ( 'Password is empty!' );
	
	// check credentials
	$conn = new MySQLConnector();
	
	$result = $conn->checkCredentials($GLOBALS['username'], $GLOBALS['password'] );
	
	if (!$result)
		throw new Exception('Wrong username or password!');

	return $result;
}

