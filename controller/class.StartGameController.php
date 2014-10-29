<?php
require_once $_SERVER ['DOCUMENT_ROOT'] . '/git/CityBuilderProd/config.php';
require_once LOCATOR . '/dal/class.MySQLConnector.php';


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
			header('Location: ../view/PlacementOfCity.php');
			exit;
			break;
	}
} 
if ($source == 'placement'){
	switch ($result) {
		case 2 :
			header('Location: ../view/PlacementOfCity.php');
			break;
		case 3 :
			header('Location: ../view/CityManagement.php?gameMode=3&zone=' .$_POST['zone']);			
			break;
		case 4 :
			header('Location: ../view/CityManagement.php?gameMode=4&zone='.$_POST['zone']);
			break;
	}
}
?>
