<?php
require_once '../config.php';
require_once LOCATOR . '/controller/class.GameController.php';
require_once LOCATOR . '/controller/class.HistoryController.php';

/**
 * CityManager Group 3
 *
 * The this page show the score and the result of the game
 *
 * */

$historyController;
if (isset ( $_SESSION ['GameController'] )) {
	$gameController = unserialize ( $_SESSION ['GameController'] );
	$scoreArray = $gameController->getGameResources ()->getScore ();
	$technology = $scoreArray ['tech'];
	$wealth = $scoreArray ['wealth'];
	$buildings = $scoreArray ['building'];
	$population = $scoreArray ['population'];
	$happiness = $scoreArray ['happiness'];
	$score = ceil ( (1 + $technology + $wealth + $buildings + $population + $happiness)* 2 ) / 2;
} else {
	if (isset ( $_POST ['game_ID'] )) {
		// Not tested
		$historyController = new historyController ( $_POST ['game_ID'] );
	}
	$technology = $historyController->getScTechnology ();
	$wealth = $historyController->getScWealth ();
	$buildings = $historyController->getScBuildings ();
	$population = $historyController->getScPopulation ();
	$happiness = $historyController->getScHappiness ();
	$score = $historyController->getScTotal ();
}

?>
<div id="header" style="width: 300px;">Scores</div>

<div id="leftContentScore" style="padding-top: 150px;">

	<div id="Controles">
		<table style='margin-left: 20px;'>
			<tr>
				<td id='scoreTech' class="lScore hover"><?php echo gettext('Technology')?> .....................................</td>
				<td id='scoreTechNb' class="eScore hover"><?php echo $technology; ?></td>
			</tr>
			<tr>
				<td id='scoreWealth' class="lScore hover"><?php echo gettext('Wealth')?> .....................................</td>
				<td id='scoreWealthNb' class="eScore hover"><?php echo $wealth; ?></td>
			</tr>
			<tr>
				<td id='scoreBuilding' class="lScore hover"><?php echo gettext('Buildings')?> .....................................</td>
				<td id='scoreBuildingNb' class="eScore hover"><?php echo $buildings; ?></td>
			</tr>
			<tr>
				<td id='scorePop' class="lScore hover"><?php echo gettext('Population')?> .....................................</td>
				<td id='scorePopNb' class="eScore hover"><?php echo $population; ?></td>
			</tr>
			<tr>
				<td id='scoreUnhappiness' class="lScore hover"><?php echo gettext('Happiness')?> .....................................</td>
				<td id='scoreUnhappinessNb' class="eScore hover"><?php echo $happiness; ?></td>
			</tr>
			<tr>
				<td id='scoreTotal' class="lScore hover"><?php echo gettext('Total score')?> .....................................</td>
				<td id='scoreTotalNb' class="eScore hover"><?php echo $score; ?></td>
			</tr>
		</table>
		<div style="clear: both"></div>
	</div>
	<div
		style="background: none; border: 0; float: left; width: 330px; background: none; border: 0; margin-right: 50px; margin-top: 5px; font-size: 20px; text-align: justify;">
		<?php
		if ($score >= 5) {
			echo "<img src='css/images/end/end_good.png' width='100%'/>";
			echo "<div style='padding:2px;'>";
			echo gettext ( 'Your reign is an example to all your peers, who, following it, will accomplish great feats too. Your city will be remembered through the ages.' );
			echo "</div>";
		} elseif ($score >= 4) {
			echo "<img src='css/images/end/end_med.png' width='100%' />";
			echo "<div style='padding:2px;'>";
			echo gettext ( 'At the end of your reign, you leave behind you a florishing city. But its small size and lack of prestige will condemn it to be forgotten.' );
			echo "</div>";
		} else {
			echo "<img src='css/images/end/end_bad.png' width='100%'/>";
			echo "<div style='padding:2px;'>";
			echo gettext ( 'Your reign is over. Your citizen flee the city. You will have to wait for archeology to appear before your city is found again.' );
			echo "</div>";
		}
		?>
	</div>
</div>
<div id="rightContent">
	<div id="rightUp">
		<img src='css/images/blank.png' id='flavourImage'
			style='width: 180px; height: 150px;' />
		<p id='flavourText'></p>
	</div>


	<div id="rightBottom">
		<input type='button' value='<?php echo gettext('Exit game');?>'
			name='startMenu' class='pageButtons link' style="margin-top: 90px;" />
	</div>
</div>
<div style="clear: both;"></div>
