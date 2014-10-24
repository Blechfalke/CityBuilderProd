<?php

require_once '../config.php';

require_once LOCATOR . '/controller/class.GameController.php';

if (isset ( $_SESSION ['GameController'] )) {
	$gameController = unserialize ( $_SESSION ['GameController'] );
} else {
	$gameController = new GameController ();
}
$score = $gameController->getGameResources ()->getScore ();
$technology = $score["tech"];

//$technology = $gameController->getGameResources ()->getScore ()["tech"];
$wealth = $gameController->getGameResources ()->getScore ()["wealth"];
$buildings = $gameController->getGameResources ()->getScore ()["building"];
$population = $gameController->getGameResources ()->getScore ()["population"];
$happiness = $gameController->getGameResources ()->getScore ()["happiness"];
$score = 1+$gameController->getGameResources ()->getScore ()["tech"] + $gameController->getGameResources ()->getScore ()["wealth"] + $gameController->getGameResources ()->getScore ()["building"] + $gameController->getGameResources ()->getScore ()["population"] + $gameController->getGameResources ()->getScore ()["happiness"];
?>
<div id="header" style="width: 300px;">Scores</div>

<div id="leftContent" style="padding-top: 150px;">

	<div id="Controles">
		<div class="pairControl">
			<div style="background-color: white;" class="label"><?php echo gettext('Technology')?></div>
			<div class="editor"><?php echo $technology ?></div>
		</div>
		<div class="pairControl">
			<div style="background-color: white;" class="label"><?php echo gettext('Wealth')?></div>
			<div class="editor"><?php echo $wealth ?></div>
		</div>
		<div class="pairControl">
			<div style="background-color: white;" class="label"><?php echo gettext('Buildings')?></div>
			<div class="editor"><?php echo $buildings ?></div>
		</div>
		<div class="pairControl">
			<div style="background-color: white;" class="label"><?php echo gettext('Population')?></div>
			<div class="editor"><?php echo $population ?></div>
		</div>
		<div class="pairControl">
			<div style="background-color: white;" class="label"><?php echo gettext('Happiness')?></div>
			<div class="editor"><?php echo $happiness ?></div>
		</div>
		<div style="clear: both; width: 30px; height: 20px;"></div>
		<div class="pairControl">
			<div style="background-color: white;" class="label"><?php echo gettext('Total score')?></div>
			<div class="editor"><?php echo $score ?></div>
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
