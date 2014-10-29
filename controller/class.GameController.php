<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/git/CityBuilderProd/config.php');
require_once LOCATOR . '/dal/class.MySQLConnector.php';
require_once LOCATOR . '/model/class.Building.php';
require_once LOCATOR . '/model/class.GameResources.php';
require_once LOCATOR . '/model/class.Population.php';
require_once LOCATOR . '/model/class.Technology.php';
require_once LOCATOR . '/model/class.SingleGameHistoric.php';
require_once LOCATOR . '/model/class.Turn.php';
class GameController {
	private $round;
	private $buildings;
	private $gameResources;
	private $population;
	private $technology;
	private $singleGameHistoric;
	private $nextRoundPopupText;
	private $maxTurn;
	private $gameDBId;
	
	public function __construct() {
		$this->round = 0;
		$this->buildings = new Building ();
		$this->gameResources = new GameResources ();
		$this->population = new Population ();
		$this->technology = new Technology ();
		$this->singleGameHistoric = null;
		$this->nextRoundPopupText;
		$this->maxTurn = 6;
		$this->gameDBId = null;
	}
	public function getRound() {
		return $this->round;
	}
	public function nextRound() {
		$this->round ++;
	}
	public function getBuildings() {
		return $this->buildings;
	}
	public function getGameResources() {
		return $this->gameResources;
	}
	public function getPopulation() {
		return $this->population;
	}
	public function getTechnology() {
		return $this->technology;
	}
	public function getSingleGameHistoric() {
		return $this->singleGameHistoric;
	}
	public function getNextRoundPopupText() {
		return $this->nextRoundPopupText;
	}
	public function calculateRound() {
		$conn = new MySQLConnector ();
		$this->population->updatePopulation ( isset ( $_POST ['kings'] ) ? $_POST ['kings'] : 0, isset ( $_POST ['priests'] ) ? $_POST ['priests'] : 0, isset ( $_POST ['craftsmen'] ) ? $_POST ['craftsmen'] : 0, isset ( $_POST ['scribes'] ) ? $_POST ['scribes'] : 0, isset ( $_POST ['soldiers'] ) ? $_POST ['soldiers'] : 0, isset ( $_POST ['peasants'] ) ? $_POST ['peasants'] : 0, isset ( $_POST ['slaves'] ) ? $_POST ['slaves'] : 0 );
		
		if (! $this->technology->getWriting ())
			$this->population->setScribes ( 0 );
		
		if ($this->round == 0) {
			// INITALISATION ROUND
			// historic registration of the zone
			$user = unserialize ( $_SESSION ['User'] );
			//$playerID, $mapZone,$gameModeId
			$this->singleGameHistoric = new SingleGameHistoric ($conn->getIdByUsername($user->username), $_GET ['zone'],$conn->getGameMode () );
			// 1: Block 2: map only 3: 5 turn 4: infinite
			switch ($this->singleGameHistoric->getGameModeId ()) {
				case 1 :
					header ( 'Location: ../view/startMenu.php' );
					break;
				case 2 :
					header ( 'Location: ../view/startMenu.php' );
					break;
				case 3 :
					$this->maxTurn = 5;
					break;
				case 4 :
					$this->maxTurn = 999;
					break;
				default :
					header ( 'Location: ../view/startMenu.php' );
					break;
			}
			// Zone infulence
			switch ($_GET ['zone']) {
				case 'zone_1' :
					$popT = 2000;
					echo "<script>project.alert('" . gettext ( 'You have chosen to found your city in the middle of fertile lands, irrigated by the river. The recolts will be aboundants.' ) . "');</script>";
					break;
				case 'zone_2' :
					$popT = 1500;
					echo "<script>project.alert('" . gettext ( 'You have chosen to found your city in the desert. We have found a few oasises that should provide a bit of food to survive' ) . "');</script>";
					break;
				case 'zone_3' :
					$popT = 1200;
					echo "<script>project.alert('" . gettext ( 'You have chosen to found your city in the mountains.  A few water sources will help us gather the bare minimal we need.' ) . "');</script>";
					break;
				default :
					$popT = 2000;
					break;
			}
			$this->population->setTotalPopulation ( $popT );
			$this->gameResources->setFood ( $popT / 2 );
			$this->gameResources->setWealth ( $popT / 4 );
			$this->technology = new Technology ();
			$this->calcScore ();
			// registering and stuff
			$turn = new Turn ( clone $this->population, clone $this->technology );
			$this->singleGameHistoric->appendTurn ( $turn );
			$this->gameDBId = $conn->insertGame ( clone $this->singleGameHistoric );
			$conn->insertTurn ( $this->gameDBId, null, $this->round, $turn );
		} else {
			// EVERY OTHER ROUNDS
			
			// historic registration (before the calculation, we want to register the choices of the user
			$turn = new Turn ( clone $this->population, clone $this->technology );
			$this->singleGameHistoric->appendTurn ( $turn );
			$DBtechnology = (isset ( $_POST ['technology'] ) ? $_POST ['technology'] : "NONE");
			if ($DBtechnology == 'pottery')
				$this->nextRoundPopupText [] = gettext ( 'You have discovered the art of the pottery. Your craftsmen now generate more wealth.' );
			elseif ($DBtechnology == 'granary')
				$this->nextRoundPopupText [] = gettext ( 'You have discovered the granary. Your citizen are now able to store food.' );
			elseif ($DBtechnology == 'writing')
				$this->nextRoundPopupText [] = gettext ( 'You have discovered writing. This allows you to assign some of your citizens to become scribes to optimize the production.' );
			
			$conn->insertTurn ( $this->gameDBId, $DBtechnology, $this->round, $turn );
			// echo 'GameHistoric'.$this->singleGameHistoric->getTurns()[0]->getPopulation()->getKings();
			// echo print_r($this->singleGameHistoric->getTurns());
			$this->calcInvasion ();
			$this->calcUnhappiness ();
			$this->calcWealth ();
			$this->calcCaravan ();
			$this->calcBuildings ();
			$this->calcFoodPop ();
			$this->calcScore ();
			// TURN POPUP
			$text = gettext ( "Turn" ) . " " . $this->round . "<hr />";
			foreach ( $this->nextRoundPopupText as $textLine )
				$text = $text . "<p>" . $textLine . "</p>";
			echo "<script>project.alert('" . $text . "');</script>";
			$this->nextRoundPopupText = array ();
			
			$this->technology->updateTechnology ( isset ( $_POST ['technology'] ) ? $_POST ['technology'] : "" );
			if ($this->population->getTotalPopulation () <= 0) {
				// LOSING EVENT
				
				// TODO POPUP TEXT
				// echo "<script>project.alert('LOST');</script>";
				// TODO ONLY FOR TESTING
				$this->round = 1000;
			}
			if ($this->round >= $this->maxTurn) {
				// TODO POPUP TEXT
				// echo "<script>project.alert('WIN POPUP');</script>";
				
				// $conn->insertHistory ( clone $this->singleGameHistoric );
				
				header ( 'Location: ../view/Scores.php' );
			}
		}
		$this->nextRound ();
	}
	public function calculateRoundForScorePage(Population $pop, Technology $tech, $zone) {
		$this->population = $pop;
		
		if (! $this->technology->getWriting ())
			$this->population->setScribes ( 0 );
		
		if ($this->round == 0) {
			// Zone infulence
			switch ($zone) {
				case 'zone_1' :
					$popT = 2000;
					break;
				case 'zone_2' :
					$popT = 1500;
					break;
				case 'zone_3' :
					$popT = 1200;
					break;
			}
			$this->population->setTotalPopulation ( $popT );
			$this->gameResources->setFood ( $popT / 2 );
			$this->gameResources->setWealth ( $popT / 4 );
			$this->technology = $tech;
		} else {
			// EVERY OTHER ROUNDS
			$this->nextRoundPopupText = array ();
			$this->calcInvasion ();
			$this->calcUnhappiness ();
			$this->calcWealth ();
			$this->calcCaravan ();
			$this->calcBuildings ();
			$this->calcFoodPop ();
			$this->calcScore ();
			// TODO vvv probably wrong Check it vvv
			$this->technology = $tech;
			if ($this->population->getTotalPopulation () <= 0) {
				// LOSING EVENT
				
				$this->round = 3000;
			}
		}
		$this->nextRound ();
	}
	public function calcInvasion() {
		// INVASION
		if ($this->population->getTotalPopulation () != 0)
			if (($this->population->getSoldiers () / $this->population->getTotalPopulation () * 100.0) <= (2.5)) {
				// TODO POPUP TEXT
				// echo "<script>project.alert('Invasion POPUP');</script>";
				
				$this->nextRoundPopupText [] = gettext ( 'An enemy army has invaded your city and routed your too few soldiers. They loot a part of your wealth and take a part of your population as slaves.' );
				
				$LostPop = ceil ( ((3 - $this->population->getSoldiers () / $this->population->getTotalPopulation () * 100) * 5) * $this->population->getTotalPopulation () / 100 );
				$LostWealth = ((3 - $this->population->getSoldiers () / $this->population->getTotalPopulation () * 100) * 5) * $this->population->getTotalPopulation () / 100;
				
				$this->population->setTotalPopulation ( $this->population->getTotalPopulation () - $LostPop );
				$this->gameResources->setWealth ( $this->gameResources->getWealth () - $LostPop );
				// TODO ONLY FOR TESTING
				// echo 'invasion pop lost: ' . $LostPop . ' wealth lost: ' . $LostWealth;
				$this->ClassesLossesFromInv ( $LostPop );
			}
	}
	public function ClassesLossesFromInv($LostPop) {
		// INVASION DEAD CALC
		$array = array (
				$this->population->getSoldiers (),
				$this->population->getPeasants (),
				$this->population->getSlaves (),
				$this->population->getCraftsmen (),
				$this->population->getScribes (),
				$this->population->getPriests (),
				$this->population->getKings () 
		);
		$array = $this->ClassesLosses ( $array, 0, $LostPop );
		$this->population->setSoldiers ( $array [0] );
		$this->population->setPeasants ( $array [1] );
		$this->population->setSlaves ( $array [2] );
		$this->population->setCraftsmen ( $array [3] );
		$this->population->setScribes ( $array [4] );
		$this->population->setPriests ( $array [5] );
		$this->population->setKings ( $array [6] );
	}
	public function ClassesLossesFromFood($LostPop) {
		// STARVATION CALC
		$array = array (
				$this->population->getSlaves (),
				$this->population->getPeasants (),
				$this->population->getCraftsmen (),
				$this->population->getScribes (),
				$this->population->getPriests (),
				$this->population->getSoldiers (),
				$this->population->getKings () 
		);
		$array = $this->ClassesLosses ( $array, 0, $LostPop );
		$this->population->setSlaves ( $array [0] );
		$this->population->setPeasants ( $array [1] );
		$this->population->setCraftsmen ( $array [2] );
		$this->population->setScribes ( $array [3] );
		$this->population->setPriests ( $array [4] );
		$this->population->setSoldiers ( $array [5] );
		$this->population->setKings ( $array [6] );
	}
	private function ClassesLosses($array, $class, $LostPop) {
		// Class losses algorithm
		if ($array [$class] < $LostPop) {
			$LostPop = $LostPop - $array [$class];
			$array [$class] = 0;
			$class ++;
			if ($class < count ( $array ))
				$array = $this->ClassesLosses ( $array, $class, $LostPop );
		} else {
			$array [$class] = $array [$class] - $LostPop;
		}
		return $array;
	}
	public function calcUnhappiness() {
		// UNHAPPINESS
		$this->gameResources->setUnhappiness ( false );
		if (($this->population->getKings () != 1) or ($this->population->getPriests () / $this->population->getTotalPopulation () * 100.0 <= 0.25) or ($this->population->getSlaves () / $this->population->getTotalPopulation () * 100.0 <= 2.0)) {
			$this->gameResources->setUnhappiness ( true );
			// TODO POPUP TEXT
			// echo "<script>project.alert('Unhappiness POPUP');</script>";
			$this->nextRoundPopupText [] = gettext ( 'Your population is unhappy. You should quickly find the reason and act before the unrest takes its toll.' );
			// TODO ONLY FOR TESTING
			// echo ' the population is angry ';
		}
	}
	public function calcWealth() {
		// WEALTH
		$potmod = 0;
		if ($this->technology->getPottery ())
			$potmod = 2;
		$WealthProd = $this->population->getCraftsmen () * (10 + $potmod);
		$this->gameResources->setWealth ( $this->gameResources->getWealth () + $WealthProd );
		
		// TODO ONLY FOR TESTING
		// echo ' current wealth: ' . $this->gameResources->getWealth ();
	}
	public function calcCaravan() {
		// CARAVAN CALCULATION
		if ($this->gameResources->getWealth () >= 550) {
			$this->gameResources->incCaravans ();
			
			// TODO POPUP TEXT
			// echo "<script>project.alert('CARAVAN POPUP');</script>";
			$this->nextRoundPopupText [] = gettext ( 'Your first caravan has been sent to a neighbor city. Your wealth increase.' );
			// TODO ONLY FOR TESTING
			// echo ' caravan sent';
		}
	}
	public function calcBuildings() {
		// BUILDING
		if ($this->population->getPriests () >= 10 && $this->gameResources->getWealth () >= 550 && $this->population->getPeasants () >= 1000) {
			$this->buildings->buildTemple ();
			// TODO POPUP TEXT
			// echo "<script>project.alert('temple POPUP');</script>";
			$this->nextRoundPopupText [] = gettext ( 'Your workers have built a temple to celebrate the glory of the city protecting god. Your own prestige greatly increases.' );
			// TODO ONLY FOR TESTING
			// echo ' temple built';
		}
		if ($this->gameResources->getWealth () >= 850 && $this->population->getPeasants () >= 1500) {
			$this->buildings->buildPalace ();
			// TODO POPUP TEXT
			// echo "<script>project.alert('palace POPUP');</script>";
			$this->nextRoundPopupText [] = gettext ( 'Your workers have finished the construction of the palace. It will be your home and the center of your government.' );
			// TODO ONLY FOR TESTING
			// echo ' palace built';
		}
		if ($this->gameResources->getWealth () >= 1150 && $this->population->getPeasants () >= 1900) {
			$this->buildings->buildMonuments ();
			// TODO POPUP TEXT
			// echo "<script>project.alert('monument POPUP');</script>";
			$this->nextRoundPopupText [] = gettext ( 'To honor your souvenir, your workers have begun the construction of a pyramid. It will stay as the proof of your glory for all to admire.' );
			// TODO ONLY FOR TESTING
			// echo ' monuments built';
		}
	}
	public function calcFoodPop() {
		if ($this->population->getTotalPopulation () != 0) {
			// FOOD PRODUCTION
			$scribesInfulence = (0.0277777778 * 100 * ($this->population->getScribes () / $this->population->getTotalPopulation () * 100));
			if ($scribesInfulence > 0.0277777778)
				$scribesInfulence = 0.0277777778;
			$foodProd = floor ( $this->population->getPeasants () * (($this->gameResources->getUnhappiness ()) ? 0.75 : 1) * (1.111111111 + $scribesInfulence) );
			// TODO ONLY FOR TESTING
			// echo ' food produced: ' . $foodProd;
			
			// FOOD CONSUMPTION
			$foodCons = $this->population->getTotalPopulation ();
			// TODO ONLY FOR TESTING
			// echo ' food consumed: ' . $foodCons;
			// FOOD REMAINING
			if ($this->technology->getGranary ())
				$this->gameResources->setFood ( $this->gameResources->getFood () - $foodCons + $foodProd );
			else
				$this->gameResources->setFood ( $foodProd - $foodCons );
				// TODO ONLY FOR TESTING
				// POPULATION VARIATION
			$PopVar = floor ( $this->gameResources->getFood () * 2 );
			// echo ' pop variation : ' . $PopVar;
			$NewPop = $this->population->getTotalPopulation () + $PopVar;
			if ($this->gameResources->getFood () < 0) {
				if ($NewPop <= 0.5 * $this->population->getTotalPopulation ())
					$NewPop = ceil ( 0.5 * $this->population->getTotalPopulation () );
				$LostPop = $this->population->getTotalPopulation () - $NewPop;
				$this->ClassesLossesFromFood ( $LostPop );
			}
			$this->population->setTotalPopulation ( $NewPop );
			
			if (! $this->technology->getGranary () || $this->gameResources->getFood () < 0)
				$this->gameResources->setFood ( 0 );
			// TODO FOR TESTING
			// echo ' food remaining: ' . $this->gameResources->getFood ();
			// echo ' population: ' . $this->population->getTotalPopulation ();
		}
	}
	public function calcScore() {
		// SCORE CALCULATION
		$score = array (
				'tech' => 0,
				'wealth' => 0,
				'building' => 0,
				'population' => 0,
				'happiness' => 0 
		);
		// TECH
		if ($this->technology->getGranary ())
			$score ['tech'] += 0.5;
		if ($this->technology->getPottery ())
			$score ['tech'] += 0.5;
		if ($this->technology->getWriting ())
			$score ['tech'] += 0.5;
			// WEALTH
		$score ['wealth'] = ceil ( ($this->gameResources->getWealth () / 500.0 * 0.2) * 2 ) / 2;
		$score ['wealth'] = ($score ['wealth'] > 1) ? 1 : $score ['wealth'];
		// BUILDING
		$score ['building'] = ($this->buildings->getTemple () + $this->buildings->getPalace () + $this->buildings->getMonuments ()) * 0.125;
		$score ['building'] = ($score ['building'] > 0.5) ? 0.5 : $score ['building'];
		// POP
		$score ['population'] = $this->population->getTotalPopulation () / 50 * 0.03125;
		$score ['population'] = ($score ['population'] > 1.5) ? 1.5 : $score ['population'];
		// UNHAPPINESS
		$score ['population'] = ($this->gameResources->getUnHappiness ()) ? 0 : 0.5;
		$this->gameResources->setScore ( $score );
	}
}

?>