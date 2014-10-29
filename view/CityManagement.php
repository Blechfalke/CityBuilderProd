﻿<?php 
require_once '../config.php';
require_once LOCATOR . '/controller/class.GameController.php';

if (isset($_SESSION['GameController'])) {
	$gameController = unserialize($_SESSION['GameController']);
} else {
	$gameController = new GameController();
}


$gameController->calculateRound();
$population = $gameController->getPopulation();
$technology = $gameController->getTechnology();
$totalPopulation = $population->getTotalPopulation();
$kings = $population->getKings();
$priests = $population->getPriests();
$craftsmen = $population->getCraftsmen();
$scribes = $population->getScribes();
$soldiers = $population->getSoldiers();
$peasants = $population->getPeasants();
$slaves = $population->getSlaves();
$caravans = $gameController->getGameResources()->getCaravans();
$wealth = $gameController->getGameResources()->getWealth();
$food = $gameController->getGameResources()->getFood();
$availablePopulation = $totalPopulation - $kings -$priests - $craftsmen - $scribes - $soldiers - $peasants - $slaves;


$_SESSION['GameController'] = serialize($gameController);

// if ($gameController->getRound() > 6) {
// 	echo "<div>Game finished</div>";
// } else {
	echo "<div id='header'>". gettext('Management of the city') ."</div>

        <div id='leftContent'>
            <div style='width: 652px;'>
                <div style='margin-top: 45px; margin-left: 25px;'>
                    <div class='pairControl'>
			<div style='width:25%; float: left;text-align:right;padding-right:1px;'>". gettext('Food'). "</div>
			<div style='width:25%; float: left; background:white;border:1px black solid;margin:-1px;'>$food</div>
			<div style='width:20%; float: left;text-align:right;padding-right:1px;'>". gettext('Wealth'). "</div>
			<div style='width:25%; float: left; background:white;border:1px black solid;margin:-1px;'>$wealth</div>
		<div style='clear: both'></div>
                    </div>
                </div>
                <div style='float: left; margin: 10px 0 0 35px;'>
                    <div style='float: left; margin-right: 30px; margin-left: 30px;'>
                        <div style='float: left; margin: 10px;'>". gettext('Choose one technology per turn')."</div>
                        <div style='float: right;'>
                            <img src='css/images/arrow.png' width='40' /></div>
                    </div>
                    <div style='clear: both'></div>
                    <div style='float: left; margin-right: 30px;'>
                        <div style='float: left; margin: 10px 5px;'>". gettext('Assign the citizen to a social class'). "</div>
                        <div style='float: right;'>
                            <img src='css/images/arrowDown.png' height='40' /></div>
                    </div>
                </div>
                <div style='float: right;'>

                    <div class='imageCityManagement'>
                        ". gettext('Writing')." 
                        <img class='checkmark' src='css/images/checkmark.png'/>
                        <img id='writing' class='technology hover ";
                        echo $technology->getWriting() ? "developed" : "clickable";
                        echo "' src='css/images/writing.png' width='70' style='margin: 5px 30px 0 0;' />
                    </div>
                    <div class='imageCityManagement'>
                        ". gettext('Granary')."
                        <img class='checkmark' src='css/images/checkmark.png'/>
                        <img id='granary' class='technology hover "; 
                        echo $technology->getGranary() ? "developed" : "clickable";
                        echo "' src='css/images/granary.png' width='70' style='margin: 5px 30px 0 0;' />
                    </div>
                    <div  class='imageCityManagement' style='margin-right:0;'>
                        ". gettext('Pottery')."
                        <img class='checkmark' src='css/images/checkmark.png'/>
                        <img id='pottery' class='technology hover ";
                        echo $technology->getPottery() ? "developed" : "clickable";
                        echo "' src='css/images/pottery.png' width='70' style='margin-top: 5px;' />
                    </div>
                </div>
		<div style='clear: both'></div>
            </div>
            <div style='clear: both'></div>
	<div id='Controles'>
	<div class='pairControl'>
	<div style='background-color:white;' class='label'>
	". gettext('Total population')."
	</div>
	<input type='text' class='editor' name='TotalPopulation' id='TotalPopulation' disabled value='$totalPopulation'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:white;' class='label'>
	". gettext('Available population')."
	</div>
	<input type='text' class='editor' name='AvailablePopulation' id='AvailablePopulation' disabled value='$availablePopulation'/>
	</div>
	<div style='clear:both;width:30px; height:20px;'>
	</div>
	<div class='pairControl'>
	<div style='background-color:#FFF2CC;' class='label hover' id='lbl_Kings'>
	". gettext('Kings')."
	</div>
	<input type='number' min='0' class='editor' name='Kings' id='Kings' oninput='updateAvailablePopulation($(this))' value='$kings'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:#CC99FF;' class='label hover' id='lbl_Priests'>
	". gettext('Priests')."
	</div>
	<input type='number' min='0' class='editor' name='Priests' id='Priests' oninput='updateAvailablePopulation($(this))' value='$priests'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:#FBE5D6;' class='label hover' id='lbl_Craftsmen'>
	". gettext('Craftsmen')."
	</div>
	<input type='number' min='0' class='editor' name='Craftsmen' id='Craftsmen' oninput='updateAvailablePopulation($(this))' value='$craftsmen'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:#9DC3E6;' class='label hover' id='lbl_Scribes'>
	". gettext('Scribes')."
	</div>
    <input type='number' min='0' class='editor' name='Scribes' id='Scribes' oninput='updateAvailablePopulation($(this))' ";
	echo $technology->getWriting() ? "" : "disabled ";
	echo "value='$scribes'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:#FF5050;' class='label hover' id='lbl_Soldiers'>
	". gettext('Soldiers')."
	</div>
	<input type='number' min='0' class='editor' name='Soldiers' id='Soldiers' oninput='updateAvailablePopulation($(this))' value='$soldiers'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:#C5E0B4;' class='label hover' id='lbl_Peasants'>
	". gettext('Peasants')."
	</div>
	<input type='number' min='0' class='editor' name='Peasants' id='Peasants' oninput='updateAvailablePopulation($(this))' value='$peasants'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:#DBDBDB;' class='label hover' id='lbl_Slaves'>
	". gettext('Slaves')."
	</div>
	<input type='number' min='0' class='editor' name='Slaves' id='Slaves' oninput='updateAvailablePopulation($(this))' value='$slaves'/>
	</div>
	<div style='clear:both;width:30px; height:20px;'>
	</div>
	<div class='pairControl'>
	<div style='background-color:#FFFFFF;' class='label hover' id='lbl_Caravans'>
	". gettext('Caravans')."
	</div>
	<input type='text' class='editor' name='Caravans' id='Caravans' disabled oninput='updateAvailablePopulation()' value='$caravans'/>
	</div>
	<div style='clear:both'>
	</div>
	</div>
	<div id='Diagram'>
	</div>
	</div>
	<div id='rightContent'>
	<div id='rightUp'>
		<img src='css/images/blank.png' id='flavourImage' style='width:180px; height:150px;'/>
		<p id='flavourText'> </p>
	</div>
	<div id='rightBottom'>
	<input type='button' value='" . gettext('End  of turn') . "' name='EndOfTurn' class='pageButtons finishRound' id='endTheTurn'/>
	<input type='button' value='" . gettext('Exit game') . "' name='startMenu' class='pageButtons' id='quitTheGame'/>
	</div>
	</div>
	<div style='clear:both;'>
	</div>
	<script>
		updateTechnology();
		createPyramid();
		updatePyramid($slaves, $peasants, $soldiers, $craftsmen, $scribes, $priests, $kings);
  	</script>";
// }
?>
