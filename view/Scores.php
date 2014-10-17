<?php session_start();
require_once ($_SERVER['DOCUMENT_ROOT'] . '/git/CityBuilderProd/config.php');
require_once LOCATOR . '/controller/class.GameController.php';

if (isset($_SESSION['GameController'])) {
	$gameController = unserialize($_SESSION['GameController']);
} else {
	$gameController = new GameController();
}

$technology = $gameController->getTechnology();
$wealth = $gameController->getGameResources()->getWealth();
$buildings= "TOBECALCULATED";
$population= $gameController->getPopulation();
$happiness= "TOBECALCULATED";
$score= $gameController->getGameResources()->getScore();
?>
<div id="header" style="width: 300px;">Scores</div>

<div id="leftContent" style="padding-top: 150px;">

	<div id="Controles">
		<div class="pairControl">
			<div style="background-color: white;" class="label">Technology</div>
			<div class="editor"><?php $technology ?></div>
		</div>
		<div class="pairControl">
			<div style="background-color: white;" class="label">Wealth</div>
			<div class="editor"><?php $wealth ?></div>
		</div>
		<div class="pairControl">
			<div style="background-color: white;" class="label">Buildings</div>
			<div class="editor"><?php $buildings ?></div>
		</div>
		<div class="pairControl">
			<div style="background-color: white;" class="label">Population</div>
			<div class="editor"><?php $population ?></div>
		</div>
		<div class="pairControl">
			<div style="background-color: white;" class="label">Happiness</div>
			<div class="editor"><?php $happiness ?></div>
		</div>
		<div style="clear: both; width: 30px; height: 20px;"></div>
		<div class="pairControl">
			<div style="background-color: white;" class="label">Total score</div>
			<div class="editor"><?php $score ?></div>
		</div>
		<div style="clear: both"></div>
	</div>
	<div id="Diagram" style="height: 204px;"></div>
</div>
<div id="rightContent">
	<div id="rightUp">
		<div id="textRightup">
			<!-- text for small right block here -->
		</div>
	</div>
	<div id="rightBottom">
		<input type="button" value="Exit game" name="ExitGame"
			class="pageButtons" style="margin-top: 90px;" />
	</div>
</div>
<div style="clear: both;"></div>