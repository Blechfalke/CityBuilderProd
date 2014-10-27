<?php

require_once '../config.php';

require_once LOCATOR . '/controller/class.GameController.php';
require_once LOCATOR . '/controller/class.HistoryController.php';

if (isset ( $_SESSION ['GameController'] )) {
	$gameController = unserialize ( $_SESSION ['GameController'] );
} else {
	$gameController = new GameController ();
}
$history = new HistoryController($gameController->getSingleGameHistoric());

$textHistory = $history->getTextHistory();
$technology = $history->getScTechnology();
$wealth = $history->getScWealth();
$buildings = $history->getScBuildings() ;
$population = $history->getScPopulation();
$happiness= $history->getScHappiness();
$score= $history->getScTotal();
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
	<div id="Diagram" style="height: 204px;">
		<?php echo gettext('Good Ending'); echo gettext('Medium Ending'); echo gettext('Bad Ending');?>
	</div>
</div>
<div id="rightContent">
	<div id="rightUp">
		<div id="textRightup">
			<!-- text for small right block here -->
		</div>
	</div>
	
	<div id="rightBottom">
		<input type='button' value='<?php echo gettext('Exit game');?>' name='startMenu' class='pageButtons link' style="margin-top: 90px;" />
	</div>
</div>
<div style="clear: both;"></div>
