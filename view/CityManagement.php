<?php 
session_start();
require_once '../common/ConfigOptions.php';
require_once __ROOT__ . 'controller/class.GameController.php';

$gameController = unserialize($_SESSION['GameController']);

$gameController->calculateRound();

$totalPopulation = $gameController->getPopulation()->getTotalPopulation();
$gameController->getPopulation()->setTotalPopulation(($totalPopulation+200));
$gameController->nextRound();

$_SESSION['GameController'] = serialize($gameController);

if ($gameController->getRound() > 6) {
	echo "<div>Game finished</div>";
}else{
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
<input type='text' class='editor' name='TotalPopulation' id='TotalPopulation' value='$totalPopulation'/>
</div>
<div class='pairControl'>
<div style='background-color:white;' class='label'>
Available population
</div>
<input type='text' class='editor' name='AvailablePopulation' id='AvailablePopulation'/>
</div>
<div style='clear:both;width:30px; height:20px;'>
</div>
<div class='pairControl'>
<div style='background-color:#FFF2CC;' class='label'>
King
</div>
<input type='text' class='editor' name='King' id='King'/>
</div>
<div class='pairControl'>
<div style='background-color:#CC99FF;' class='label'>
Priest
</div>
<input type='text' class='editor' name='Priest' id='Priest'/>
</div>
<div class='pairControl'>
<div style='background-color:#FBE5D6;' class='label'>
Craftsmen
</div>
<input type='text' class='editor' name='Craftsmen' id='Craftsmen'/>
</div>
<div class='pairControl'>
<div style='background-color:#9DC3E6;' class='label'>
Scribes
</div>
<input type='text' class='editor' name='Scrbes' id='Scrbes'/>
</div>
<div class='pairControl'>
<div style='background-color:#FF5050;' class='label'>
Soldiers
</div>
<input type='text' class='editor' name='Solders' id='Solders'/>
</div>
<div class='pairControl'>
<div style='background-color:#C5E0B4;' class='label'>
Peasants
</div>
<input type='text' class='editor' name='Pleasant' id='Pleasant'/>
</div>
<div class='pairControl'>
<div style='background-color:#DBDBDB;' class='label'>
Slaves
</div>
<input type='text' class='editor' name='Slaves' id='Slaves'/>
</div>
<div style='clear:both;width:30px; height:20px;'>
</div>
<div class='pairControl'>
<div style='background-color:#FFFFFF;' class='label'>
Caravans
</div>
<input type='text' class='editor' name='Caravans' id='Caravans'/>
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