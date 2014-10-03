﻿<?php 
session_start();
require_once '../common/ConfigOptions.php';
require_once __ROOT__ . 'controller/class.GameController.php';

$gameController = unserialize($_SESSION['GameController']);

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
$score = $gameController->getGameResources()->getScore();
$availablePopulation = $totalPopulation - $kings -$priests - $craftsmen - $scribes - $soldiers - $peasants - $slaves;


$_SESSION['GameController'] = serialize($gameController);

if ($gameController->getRound() > 6) {
	echo "<div>Game finished</div>";
} else {
	echo "<div id='header'>Management of the city</div>

        <div id='leftContent'>
            <div style='width: 652px;'>
                <div style='margin-top: 45px; margin-left: 25px;'>
                    <div class='pairControl'>
                        <div style='background-color: white;' class='labelScore'>Score</div>
                        <div>
                            <input type='text' class='editorScore' name='Score' id='Score' disabled value='$score'/>
                        </div>
		<div style='clear: both'></div>
                    </div>
                </div>
                <div style='float: left; margin: 10px 0 0 35px;'>
                    <div style='float: left; margin-right: 30px; margin-left: 30px;'>
                        <div style='float: left; margin: 10px;'>Choose one technology per turn </div>
                        <div style='float: right;'>
                            <img src='css/images/arrow.png' width='40' /></div>
                    </div>
                    <div style='clear: both'></div>
                    <div style='float: left; margin-right: 30px;'>
                        <div style='float: left; margin: 10px 5px;'>Assign the citizen to a social class </div>
                        <div style='float: right;'>
                            <img src='css/images/arrowDown.png' height='40' /></div>
                    </div>
                </div>
                <div style='float: right;'>

                    <div class='imageCityManagement'>
                        Writing 
                        <img class='checkmark' src='css/images/checkmark.png'/>
                        <img id='writing' class='technology ";
                        echo $technology->getWriting() ? "developed" : "clickable";
                        echo "' src='css/images/writing.png' width='70' style='margin: 5px 30px 0 0;' />
                    </div>
                    <div class='imageCityManagement'>
                        Granary
                        <img class='checkmark' src='css/images/checkmark.png'/>
                        <img id='granary' class='technology "; 
                        echo $technology->getGranary() ? "developed" : "clickable";
                        echo "' src='css/images/granary.png' width='70' style='margin: 5px 30px 0 0;' />
                    </div>
                    <div  class='imageCityManagement' style='margin-right:0;'>
                        Pottery
                        <img class='checkmark' src='css/images/checkmark.png'/>
                        <img id='pottery' class='technology ";
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
	Total population
	</div>
	<input type='text' class='editor' name='TotalPopulation' id='TotalPopulation' disabled value='$totalPopulation'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:white;' class='label'>
	Available population
	</div>
	<input type='text' class='editor' name='AvailablePopulation' id='AvailablePopulation' disabled value='$availablePopulation'/>
	</div>
	<div style='clear:both;width:30px; height:20px;'>
	</div>
	<div class='pairControl'>
	<div style='background-color:#FFF2CC;' class='label hover' id='lbl_Kings'>
	Kings
	</div>
	<input type='text' class='editor' name='Kings' id='Kings' value='$kings'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:#CC99FF;' class='label hover' id='lbl_Priests'>
	Priests
	</div>
	<input type='text' class='editor' name='Priests' id='Priests' value='$priests'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:#FBE5D6;' class='label hover' id='lbl_Craftsmen'>
	Craftsmen
	</div>
	<input type='text' class='editor' name='Craftsmen' id='Craftsmen' value='$craftsmen'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:#9DC3E6;' class='label hover' id='lbl_Scribes'>
	Scribes
	</div>
    <input type='text' class='editor' name='Scribes' id='Scribes' ";
	echo $technology->getWriting() ? "" : "disabled ";
	echo "value='$scribes'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:#FF5050;' class='label hover' id='lbl_Soldiers'>
	Soldiers
	</div>
	<input type='text' class='editor' name='Soldiers' id='Soldiers' value='$soldiers'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:#C5E0B4;' class='label hover' id='lbl_Peasants'>
	Peasants
	</div>
	<input type='text' class='editor' name='Peasants' id='Peasants' value='$peasants'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:#DBDBDB;' class='label hover' id='lbl_Slaves'>
	Slaves
	</div>
	<input type='text' class='editor' name='Slaves' id='Slaves' value='$slaves'/>
	</div>
	<div style='clear:both;width:30px; height:20px;'>
	</div>
	<div class='pairControl'>
	<div style='background-color:#FFFFFF;' class='label hover' id='lbl_Caravans'>
	Caravans
	</div>
	<input type='text' class='editor' name='Caravans' id='Caravans' disabled value='$caravans'/>
	</div>
	<div style='clear:both'>
	</div>
	</div>
	<div id='Diagram'>
	</div>
	</div>
	<div id='rightContent'>
	<div id='rightUp'>
	</div>
	<div id='rightBottom'>
	<input type='button' value='End  of turn' name='EndOfTurn' class='pageButtons finishRound'/>
	<input type='button' value='Exit game' name='adminMenu' class='pageButtons link'/>
	</div>
	</div>
	<div style='clear:both;'>
	</div>
	<script>
		updateTechnology();
		createPyramid();
		updatePyramid($slaves, $peasants, $soldiers, $craftsmen, $scribes, $priests, $kings);
  	</script>";
}
?>
