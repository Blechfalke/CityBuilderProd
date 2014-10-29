<?php
require_once '../config.php';

require_once LOCATOR . '/controller/class.GameController.php';
require_once LOCATOR . '/controller/class.HistoryController.php';

if (isset ( $_SESSION ['GameController'] )) {
	$gameController = unserialize ( $_SESSION ['GameController'] );
} else {
	$gameController = new GameController ();
}

$technology = $gameController->getGameResources ()->getScore ()["tech"];
$wealth = $gameController->getGameResources ()->getScore ()["wealth"];
$buildings = $gameController->getGameResources ()->getScore ()["building"];
$population = $gameController->getGameResources ()->getScore ()["population"];
$happiness = $gameController->getGameResources ()->getScore ()["happiness"];
$score = 1 + $technology + $wealth + $buildings + $population + $happiness;

?>
<div id="header" style="width: 300px;">Scores</div>

<div id="leftContent" style="padding-top: 150px;">

	<div id="Controles">
		<div class="pairControl">
			<div id='scoreTech' style="background-color: white;" class="label hover"><?php echo gettext('Technology')?></div>
			<div id='scoreTechNb' class="editor hover"><?php echo $technology; ?></div>
		</div>
		<div class="pairControl">
			<div id='scoreWealth' style="background-color: white;" class="label hover"><?php echo gettext('Wealth')?></div>
			<div id='scoreWealthNb' class="editor hover"><?php echo $wealth; ?></div>
		</div>
		<div class="pairControl">
			<div id='scoreBuilding' style="background-color: white;" class="label hover"><?php echo gettext('Buildings')?></div>
			<div id='scoreBuildingNb' class="editor hover"><?php echo $buildings; ?></div>
		</div>
		<div class="pairControl">
			<div id='scorePop' style="background-color: white;" class="label hover"><?php echo gettext('Population')?></div>
			<div id='scorePopNb' class="editor hover"><?php echo $population; ?></div>
		</div>
		<div class="pairControl">
			<div id='scoreUnhappiness' style="background-color: white;" class="label hover"><?php echo gettext('Happiness')?></div>
			<div id='scoreUnhappinessNb' class="editor hover"><?php echo $happiness; ?></div>
		</div>
		<div style="clear: both; width: 30px; height: 20px;"></div>
		<div class="pairControl">
			<div id='scoreTotal' style="background-color: white;" class="label hover"><?php echo gettext('Total score')?></div>
			<div id='scoreTotalNb' class="editor hover"><?php echo $score; ?></div>
		</div>
		<div style="clear: both"></div>
	</div>
	<div id="Diagram" style="height: 204px;">
		<?php
		if ($score >= 5)
			echo gettext ( 'Your reign is an example to all your peers, who, following it, will accomplish great feats too. Your city will be remembered through the ages.' );
		elseif ($score >= 4)
			echo gettext ( 'At the end of your reign, you leave behind you a florishing city. But its small size and lack of prestige will condemn it to be forgotten.' );
		else
			echo gettext ( 'Your reign is over. Your citizen flee the city. You will have to wait for archeology to appear before your city is found again.' );
		
		?>
	</div>
</div>
<div id="rightContent">
	<div id="rightUp">
		<div id="textRightup">
		<img src='css/images/blank.png' id='flavourImage' style='width:180px; height:150px;'/>
		<p id='flavourText'> </p>
		</div>
	</div>

	<div id="rightBottom">
		<input type='button' value='<?php echo gettext('Exit game');?>'
			name='startMenu' class='pageButtons link' style="margin-top: 90px;" />
	</div>
</div>
<div style="clear: both;"></div>
