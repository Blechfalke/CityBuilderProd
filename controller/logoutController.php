<?php
try {
	session_start();
	session_unset();
	session_destroy();	
} catch (Exception $e) {
	echo "error occured";
	exit();
}

header('Location: ../view/login.php');

?>