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
	private $_round;
	private $_buildings;
	private $_gameResources;
	private $_population;
	private $_technology;
	private $_singleGameHistoric;
	private $_nextRoundPopupText;
	private $_maxTurn;
	private $_gameDBId;
	
	public function __construct() {
		$this->_round = 0;
		$this->_buildings = new Building ();
		$this->_gameResources = new GameResources ();
		$this->_population = new Population ();
		$this->_technology = new Technology ();
		$this->_singleGameHistoric = null;
		$this->_nextRoundPopupText;
		$this->_maxTurn = 6;
		$this->_gameDBId = null;
	}
	public function getRound() {
		return $this->_round;
	}
	public function nextRound() {
		$this->_round ++;
	}
	public function getBuildings() {
		return $this->_buildings;
	}
	public function getGameResources() {
		return $this->_gameResources;
	}
	public function getPopulation() {
		return $this->_population;
	}
	public function getTechnology() {
		return $this->_technology;
	}
	public function getSingleGameHistoric() {
		return $this->_singleGameHistoric;
	}
	public function getNextRoundPopupText() {
		return $this->_nextRoundPopupText;
	}
	public function calculateRound() {
		$conn = new MySQLConnector ();
		$this->_population->updatePopulation ( isset ( $_POST ['kings'] ) ? $_POST ['kings'] : 0, isset ( $_POST ['priests'] ) ? $_POST ['priests'] : 0, isset ( $_POST ['craftsmen'] ) ? $_POST ['craftsmen'] : 0, isset ( $_POST ['scribes'] ) ? $_POST ['scribes'] : 0, isset ( $_POST ['soldiers'] ) ? $_POST ['soldiers'] : 0, isset ( $_POST ['peasants'] ) ? $_POST ['peasants'] : 0, isset ( $_POST ['slaves'] ) ? $_POST ['slaves'] : 0 );
		
		if (! $this->_technology->getWriting ())
			$this->_population->setScribes ( 0 );
		
		if ($this->_round == 0) {
			// INITALISATION ROUND
			// historic registration of the zone
			$user = unserialize ( $_SESSION ['User'] );
			//$playerID, $mapZone,$gameModeId
			$this->_singleGameHistoric = new SingleGameHistoric ($conn->getIdByUsername($user->username), $_GET ['zone'],$conn->getGameMode () );
			// 1: Block 2: map only 3: 5 turn 4: infinite
			switch ($this->_singleGameHistoric->getGameModeId ()) {
				case 1 :
					header ( 'Location: ../view/startMenu.php' );
					break;
				case 2 :
					header ( 'Location: ../view/startMenu.php' );
					break;
				case 3 :
					$this->_maxTurn = 5;
					break;
				case 4 :
					$this->_maxTurn = 999;
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
			$this->_population->setTotalPopulation ( $popT );
			$this->_gameResources->setFood ( $popT / 2 );
			$this->_gameResources->setWealth ( $popT / 4 );
			$this->_technology = new Technology ();
			$this->calcScore ();
			// registering and stuff
			$turn = new Turn ( clone $this->_population, clone $this->_technology );
			$this->_singleGameHistoric->appendTurn ( $turn );
			$this->_gameDBId = $conn->insertGame ( clone $this->_singleGameHistoric );
			$conn->insertTurn ( $this->_gameDBId, null, $this->_round, $turn );
		} else {
			// EVERY OTHER ROUNDS
			
			// historic registration (before the calculation, we want to register the choices of the user
			$turn = new Turn ( clone $this->_population, clone $this->_technology );
			$this->_singleGameHistoric->appendTurn ( $turn );
			$DBtechnology = (isset ( $_POST ['technology'] ) ? $_POST ['technology'] : "NONE");
			if ($DBtechnology == 'pottery')
				$this->_nextRoundPopupText [] = gettext ( 'You have discovered the art of the pottery. Your craftsmen now generate more wealth.' );
			elseif ($DBtechnology == 'granary')
				$this->_nextRoundPopupText [] = gettext ( 'You have discovered the granary. Your citizen are now able to store food.' );
			elseif ($DBtechnology == 'writing')
				$this->_nextRoundPopupText [] = gettext ( 'You have discovered writing. This allows you to assign some of your citizens to become scribes to optimize the production.' );
			
			$conn->insertTurn ( $this->_gameDBId, $DBtechnology, $this->_round, $turn );
			// echo 'GameHistoric'.$this->_singleGameHistoric->getTurns()[0]->getPopulation()->getKings();
			// echo print_r($this->_singleGameHistoric->getTurns());
			$this->calcInvasion ();
			$this->calcUnhappiness ();
			$this->calcWealth ();
			$this->calcCaravan ();
			$this->calcBuildings ();
			$this->calcFoodPop ();
			$this->calcScore ();
			// TURN POPUP
			$text = gettext ( "Turn" ) . " " . $this->_round . "<hr />";
			foreach ( $this->_nextRoundPopupText as $textLine )
				$text = $text . "<p>" . $textLine . "</p>";
			echo "<script>project.alert('" . $text . "');</script>";
			$this->_nextRoundPopupText = array ();
			
			$this->_technology->updateTechnology ( isset ( $_POST ['technology'] ) ? $_POST ['technology'] : "" );
			if ($this->_population->getTotalPopulation () <= 0) {
				// LOSING EVENT
				
				// TODO POPUP TEXT
				// echo "<script>project.alert('LOST');</script>";
				// TODO ONLY FOR TESTING
				$this->_round = 1000;
			}
			if ($this->_round >= $this->_maxTurn) {
				// TODO POPUP TEXT
				// echo "<script>project.alert('WIN POPUP');</script>";
				
				// $conn->insertHistory ( clone $this->_singleGameHistoric );
				
				header ( 'Location: ../view/Scores.php' );
			}
		}
		$this->nextRound ();
	}
	public function calculateRoundForScorePage(Population $pop, Technology $tech, $zone) {
		$this->_population = $pop;
		
		if (! $this->_technology->getWriting ())
			$this->_population->setScribes ( 0 );
		
		if ($this->_round == 0) {
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
			$this->_population->setTotalPopulation ( $popT );
			$this->_gameResources->setFood ( $popT / 2 );
			$this->_gameResources->setWealth ( $popT / 4 );
			$this->_technology = $tech;
		} else {
			// EVERY OTHER ROUNDS
			$this->_nextRoundPopupText = array ();
			$this->calcInvasion ();
			$this->calcUnhappiness ();
			$this->calcWealth ();
			$this->calcCaravan ();
			$this->calcBuildings ();
			$this->calcFoodPop ();
			$this->calcScore ();
			// TODO vvv probably wrong Check it vvv
			$this->_technology = $tech;
			if ($this->_population->getTotalPopulation () <= 0) {
				// LOSING EVENT
				
				$this->_round = 3000;
			}
		}
		$this->nextRound ();
	}
	public function calcInvasion() {
		// INVASION
		if ($this->_population->getTotalPopulation () != 0)
			if (($this->_population->getSoldiers () / $this->_population->getTotalPopulation () * 100.0) <= (2.5)) {
				// TODO POPUP TEXT
				// echo "<script>project.alert('Invasion POPUP');</script>";
				
				$this->_nextRoundPopupText [] = gettext ( 'An enemy army has invaded your city and routed your too few soldiers. They loot a part of your wealth and take a part of your population as slaves.' );
				
				$LostPop = ceil ( ((3 - $this->_population->getSoldiers () / $this->_population->getTotalPopulation () * 100) * 5) * $this->_population->getTotalPopulation () / 100 );
				$LostWealth = ((3 - $this->_population->getSoldiers () / $this->_population->getTotalPopulation () * 100) * 5) * $this->_population->getTotalPopulation () / 100;
				
				$this->_population->setTotalPopulation ( $this->_population->getTotalPopulation () - $LostPop );
				$this->_gameResources->setWealth ( $this->_gameResources->getWealth () - $LostPop );
				// TODO ONLY FOR TESTING
				// echo 'invasion pop lost: ' . $LostPop . ' wealth lost: ' . $LostWealth;
				$this->_classesLossesFromInv ( $LostPop );
			}
	}
	public function ClassesLossesFromInv($LostPop) {
		// INVASION DEAD CALC
		$array = array (
				$this->_population->getSoldiers (),
				$this->_population->getPeasants (),
				$this->_population->getSlaves (),
				$this->_population->getCraftsmen (),
				$this->_population->getScribes (),
				$this->_population->getPriests (),
				$this->_population->getKings () 
		);
		$array = $this->_classesLosses ( $array, 0, $LostPop );
		$this->_population->setSoldiers ( $array [0] );
		$this->_population->setPeasants ( $array [1] );
		$this->_population->setSlaves ( $array [2] );
		$this->_population->setCraftsmen ( $array [3] );
		$this->_population->setScribes ( $array [4] );
		$this->_population->setPriests ( $array [5] );
		$this->_population->setKings ( $array [6] );
	}
	public function ClassesLossesFromFood($LostPop) {
		// STARVATION CALC
		$array = array (
				$this->_population->getSlaves (),
				$this->_population->getPeasants (),
				$this->_population->getCraftsmen (),
				$this->_population->getScribes (),
				$this->_population->getPriests (),
				$this->_population->getSoldiers (),
				$this->_population->getKings () 
		);
		$array = $this->_classesLosses ( $array, 0, $LostPop );
		$this->_population->setSlaves ( $array [0] );
		$this->_population->setPeasants ( $array [1] );
		$this->_population->setCraftsmen ( $array [2] );
		$this->_population->setScribes ( $array [3] );
		$this->_population->setPriests ( $array [4] );
		$this->_population->setSoldiers ( $array [5] );
		$this->_population->setKings ( $array [6] );
	}
	private function _classesLosses($array, $class, $LostPop) {
		// Class losses algorithm
		if ($array [$class] < $LostPop) {
			$LostPop = $LostPop - $array [$class];
			$array [$class] = 0;
			$class ++;
			if ($class < count ( $array ))
				$array = $this->_classesLosses ( $array, $class, $LostPop );
		} else {
			$array [$class] = $array [$class] - $LostPop;
		}
		return $array;
	}
	public function calcUnhappiness() {
		// UNHAPPINESS
		$this->_gameResources->setUnhappiness ( false );
		if (($this->_population->getKings () != 1) or ($this->_population->getPriests () / $this->_population->getTotalPopulation () * 100.0 <= 0.25) or ($this->_population->getSlaves () / $this->_population->getTotalPopulation () * 100.0 <= 2.0)) {
			$this->_gameResources->setUnhappiness ( true );
			// TODO POPUP TEXT
			// echo "<script>project.alert('Unhappiness POPUP');</script>";
			$this->_nextRoundPopupText [] = gettext ( 'Your population is unhappy. You should quickly find the reason and act before the unrest takes its toll.' );
			// TODO ONLY FOR TESTING
			// echo ' the population is angry ';
		}
	}
	public function calcWealth() {
		// WEALTH
		$potmod = 0;
		if ($this->_technology->getPottery ())
			$potmod = 2;
		$WealthProd = $this->_population->getCraftsmen () * (10 + $potmod);
		$this->_gameResources->setWealth ( $this->_gameResources->getWealth () + $WealthProd );
		
		// TODO ONLY FOR TESTING
		// echo ' current wealth: ' . $this->_gameResources->getWealth ();
	}
	public function calcCaravan() {
		// CARAVAN CALCULATION
		if ($this->_gameResources->getWealth () >= 550) {
			$this->_gameResources->incCaravans ();
			
			// TODO POPUP TEXT
			// echo "<script>project.alert('CARAVAN POPUP');</script>";
			$this->_nextRoundPopupText [] = gettext ( 'Your first caravan has been sent to a neighbor city. Your wealth increase.' );
			// TODO ONLY FOR TESTING
			// echo ' caravan sent';
		}
	}
	public function calcBuildings() {
		// BUILDING
		if ($this->_population->getPriests () >= 10 && $this->_gameResources->getWealth () >= 550 && $this->_population->getPeasants () >= 1000) {
			$this->_buildings->buildTemple ();
			// TODO POPUP TEXT
			// echo "<script>project.alert('temple POPUP');</script>";
			$this->_nextRoundPopupText [] = gettext ( 'Your workers have built a temple to celebrate the glory of the city protecting god. Your own prestige greatly increases.' );
			// TODO ONLY FOR TESTING
			// echo ' temple built';
		}
		if ($this->_gameResources->getWealth () >= 850 && $this->_population->getPeasants () >= 1500) {
			$this->_buildings->buildPalace ();
			// TODO POPUP TEXT
			// echo "<script>project.alert('palace POPUP');</script>";
			$this->_nextRoundPopupText [] = gettext ( 'Your workers have finished the construction of the palace. It will be your home and the center of your government.' );
			// TODO ONLY FOR TESTING
			// echo ' palace built';
		}
		if ($this->_gameResources->getWealth () >= 1150 && $this->_population->getPeasants () >= 1900) {
			$this->_buildings->buildMonuments ();
			// TODO POPUP TEXT
			// echo "<script>project.alert('monument POPUP');</script>";
			$this->_nextRoundPopupText [] = gettext ( 'To honor your souvenir, your workers have begun the construction of a pyramid. It will stay as the proof of your glory for all to admire.' );
			// TODO ONLY FOR TESTING
			// echo ' monuments built';
		}
	}
	public function calcFoodPop() {
		if ($this->_population->getTotalPopulation () != 0) {
			// FOOD PRODUCTION
			$scribesInfulence = (0.0277777778 * 100 * ($this->_population->getScribes () / $this->_population->getTotalPopulation () * 100));
			if ($scribesInfulence > 0.0277777778)
				$scribesInfulence = 0.0277777778;
			$foodProd = floor ( $this->_population->getPeasants () * (($this->_gameResources->getUnhappiness ()) ? 0.75 : 1) * (1.111111111 + $scribesInfulence) );
			// TODO ONLY FOR TESTING
			// echo ' food produced: ' . $foodProd;
			
			// FOOD CONSUMPTION
			$foodCons = $this->_population->getTotalPopulation ();
			// TODO ONLY FOR TESTING
			// echo ' food consumed: ' . $foodCons;
			// FOOD REMAINING
			if ($this->_technology->getGranary ())
				$this->_gameResources->setFood ( $this->_gameResources->getFood () - $foodCons + $foodProd );
			else
				$this->_gameResources->setFood ( $foodProd - $foodCons );
				// TODO ONLY FOR TESTING
				// POPULATION VARIATION
			$PopVar = floor ( $this->_gameResources->getFood () * 2 );
			// echo ' pop variation : ' . $PopVar;
			$NewPop = $this->_population->getTotalPopulation () + $PopVar;
			if ($this->_gameResources->getFood () < 0) {
				if ($NewPop <= 0.5 * $this->_population->getTotalPopulation ())
					$NewPop = ceil ( 0.5 * $this->_population->getTotalPopulation () );
				$LostPop = $this->_population->getTotalPopulation () - $NewPop;
				$this->_classesLossesFromFood ( $LostPop );
			}
			$this->_population->setTotalPopulation ( $NewPop );
			
			if (! $this->_technology->getGranary () || $this->_gameResources->getFood () < 0)
				$this->_gameResources->setFood ( 0 );
			// TODO FOR TESTING
			// echo ' food remaining: ' . $this->_gameResources->getFood ();
			// echo ' population: ' . $this->_population->getTotalPopulation ();
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
		if ($this->_technology->getGranary ())
			$score ['tech'] += 0.5;
		if ($this->_technology->getPottery ())
			$score ['tech'] += 0.5;
		if ($this->_technology->getWriting ())
			$score ['tech'] += 0.5;
			// WEALTH
		$score ['wealth'] = ceil ( ($this->_gameResources->getWealth () / 500.0 * 0.2) * 2 ) / 2;
		$score ['wealth'] = ($score ['wealth'] > 1) ? 1 : $score ['wealth'];
		// BUILDING
		$score ['building'] = ($this->_buildings->getTemple () + $this->_buildings->getPalace () + $this->_buildings->getMonuments ()) * 0.125;
		$score ['building'] = ($score ['building'] > 0.5) ? 0.5 : $score ['building'];
		// POP
		$score ['population'] = $this->_population->getTotalPopulation () / 50 * 0.03125;
		$score ['population'] = ($score ['population'] > 1.5) ? 1.5 : $score ['population'];
		// UNHAPPINESS
		$score ['population'] = ($this->_gameResources->getUnHappiness ()) ? 0 : 0.5;
		$this->_gameResources->setScore ( $score );
	}
}

?>