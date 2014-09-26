<?php 
session_start();
require_once '../common/ConfigOptions.php';
require_once __ROOT__ . 'controller/class.GameController.php';

$gameController = unserialize($_SESSION['GameController']);

$gameController->calculateRound();
$population = $gameController->getPopulation();

$totalPopulation = $population->getTotalPopulation();
$kings = $population->getKings();
$priests = $population->getPriests();
$craftsmen = $population->getCraftsmen();
$scribes = $population->getScribes();
$soldiers = $population->getSoldiers();
$peasants = $population->getPeasants();
$slaves = $population->getSlaves();
$availablePopulation = $totalPopulation - $kings -$priests - $craftsmen - $scribes - $soldiers - $peasants - $slaves;


$_SESSION['GameController'] = serialize($gameController);

if ($gameController->getRound() > 6) {
	echo "<div>Game finished</div>";
} else {
	echo "<div id='header'>
	Management of the city
	</div>
	<div id='leftContent'>
	<div style='width:500px; height:150px;'>
	</div> 
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
	<div style='background-color:#FFF2CC;' class='label'>
	Kings
	</div>
	<input type='text' class='editor' name='Kings' id='Kings' value='$kings'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:#CC99FF;' class='label'>
	Priests
	</div>
	<input type='text' class='editor' name='Priests' id='Priests' value='$priests'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:#FBE5D6;' class='label'>
	Craftsmen
	</div>
	<input type='text' class='editor' name='Craftsmen' id='Craftsmen' value='$craftsmen'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:#9DC3E6;' class='label'>
	Scribes
	</div>
	<input type='text' class='editor' name='Scribes' id='Scribes' value='$scribes'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:#FF5050;' class='label'>
	Soldiers
	</div>
	<input type='text' class='editor' name='Soldiers' id='Soldiers' value='$soldiers'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:#C5E0B4;' class='label'>
	Peasants
	</div>
	<input type='text' class='editor' name='Peasants' id='Peasants' value='$peasants'/>
	</div>
	<div class='pairControl'>
	<div style='background-color:#DBDBDB;' class='label'>
	Slaves
	</div>
	<input type='text' class='editor' name='Slaves' id='Slaves' value='$slaves'/>
	</div>
	<div style='clear:both;width:30px; height:20px;'>
	</div>
	<div class='pairControl'>
	<div style='background-color:#FFFFFF;' class='label'>
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
	</div>";
}
?>