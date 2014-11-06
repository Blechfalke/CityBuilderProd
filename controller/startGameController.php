<?php
require_once 'controllerconfig.php';
require_once LOCATOR . '/dal/class.MySQLConnector.php';
/**
 * 
 * this controller verify if the user is allowed to play (related the game mode)
 * 
 */

$source = isset($_POST ['source']) ? $_POST ['source'] : 'startMenu';

$conn = new MySQLConnector();

$result = $conn->getGameMode();

// 1 - Block Game
// 2 - Placement
// 3 - 5 Turns
// 4 - Infinite

if ($source == 'startMenu') {
	switch ($result) {
		case 1 :
			header('Location: ../view/startMenu.php?msg=blocked');
			exit;
			break;
		case 2 :
		case 3 :
		case 4 :
			header('Location: ../view/placementOfCity.php');
			exit;
			break;
	}
} 
if ($source == 'placement'){
	switch ($result) {
		case 2 :
			header('Location: ../view/placementOfCity.php?msg=blocked&zone=' .$_POST['zone']);
			break;
		case 3 :
			header('Location: ../view/cityManagement.php?gameMode=3&zone=' .$_POST['zone']);			
			break;
		case 4 :
			header('Location: ../view/cityManagement.php?gameMode=4&zone='.$_POST['zone']);
			break;
	}
}
?>
