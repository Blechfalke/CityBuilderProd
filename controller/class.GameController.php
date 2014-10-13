<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/git/CityBuilderProd/config.php');
require_once LOCATOR . '/model/class.Building.php';
require_once LOCATOR . '/model/class.GameResources.php';
require_once LOCATOR . '/model/class.Population.php';
require_once LOCATOR . '/model/class.Technology.php';

class GameController {
	private $round;
	private $buildings;
	private $gameResources;
	private $population;
	private $technology;
	
	public function __construct() {
		$this->round = 1;
		$this->buildings = new Building();
		$this->gameResources = new GameResources();
		$this->population = new Population();
		$this->technology = new Technology();
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
		
	public function calculateRound() {
		$this->population->updatePopulation ( isset ( $_POST ['kings'] ) ? $_POST ['kings'] : 0, isset ( $_POST ['priests'] ) ? $_POST ['priests'] : 0, isset ( $_POST ['craftsmen'] ) ? $_POST ['craftsmen'] : 0, isset ( $_POST ['scribes'] ) ? $_POST ['scribes'] : 0, isset ( $_POST ['soldiers'] ) ? $_POST ['soldiers'] : 0, isset ( $_POST ['peasants'] ) ? $_POST ['peasants'] : 0, isset ( $_POST ['slaves'] ) ? $_POST ['slaves'] : 0 );
		$this->technology->updateTechnology ( isset ( $_POST ['technology'])? $_POST['technology']:"");
		
		if(!$this->technology->getWriting())
			$this->population->setScribes(0);
		
		if($this->round == 1){
			$popT = 2000;
			$this->population->setTotalPopulation($popT);
			$this->gameResources->setFood($popT/2);
			$this->gameResources->setWealth($popT/4);
			
		}else{
			$this->calcInvasion();
			$this->calcUnhappiness();
			$this->calcWealth();
			$this->calcCaravan();
			$this->calcBuildings();
			$this->calcFoodPop();
			$this->calcScore();
			
			if ($this->population->getTotalPopulation() <= 0){
				// LOSING EVENT
				echo '!!!!!!!!!!!!!!!!!! you\'ve lost !!!!!!!!!!!!!!!!!';
				$this->round = 1000;
			}
		}
		$this->nextRound ();
	}
	public function calcInvasion() {
		// INVASION
		if ($this->population->getSoldiers () / $this->population->getTotalPopulation () * 100 <= 2.5 / 100) {
			
			$LostPop = ceil(((3 - $this->population->getSoldiers () / $this->population->getTotalPopulation () * 100) * 5) * $this->population->getTotalPopulation () / 100);
			$LostWealth = ((3 - $this->population->getSoldiers () / $this->population->getTotalPopulation () * 100) * 5) * $this->population->getTotalPopulation () / 100;
			
			$this->population->setTotalPopulation ( $this->population->getTotalPopulation () - $LostPop );
			$this->gameResources->setWealth ( $this->gameResources->getWealth () - $LostPop );
			echo 'invasion pop lost: '.$LostPop.' wealth lost: '.$LostWealth;
			$this->ClassesLossesFromInv($LostPop);
		}
	}
	public function ClassesLossesFromInv( $LostPop){
		// INVASION DEAD CALC
		$array = array(
				$this->population->getSoldiers(),
				$this->population->getPeasants(),
				$this->population->getSlaves(),
				$this->population->getScribes(),
				$this->population->getPriests(),
				$this->population->getKings(),
		);
		$array = $this->ClassesLosses($array,0, $LostPop);
		$this->population->setSoldiers($array[0]);
		$this->population->setPeasants($array[1]);
		$this->population->setSlaves($array[2]);
		$this->population->setScribes($array[3]);
		$this->population->setPriests($array[4]);
		$this->population->setKings($array[5]);
	}
	public function ClassesLossesFromFood( $LostPop){
		// STARVATION CALC
		$array = array(
				$this->population->getPeasants(),
				$this->population->getSlaves(),
				$this->population->getSoldiers(),
				$this->population->getScribes(),
				$this->population->getPriests(),
				$this->population->getKings(),
		);
		$array = $this->ClassesLosses($array,0, $LostPop);
		$this->population->setPeasants($array[0]);
		$this->population->setSlaves($array[1]);
		$this->population->setSoldiers($array[2]);
		$this->population->setScribes($array[3]);
		$this->population->setPriests($array[4]);
		$this->population->setKings($array[5]);
	}
	private function ClassesLosses($array, $class, $LostPop){
		// Class losses algorithm
		if ($array[$class]<$LostPop)
		{
			$LostPop = $LostPop-$array[$class];
			$array[$class] = 0;
			$class++;
			if ($class < 6)
				$array = $this->ClassesLosses($array, $class, $LostPop);
		}
		else{
			$array[$class]=$array[$class]- $LostPop;
		}
		return $array;
	}
	public function calcUnhappiness() {
		// UNHAPPINESS
		$this->gameResources->setUnhappiness(false);
		if ($this->population->getKings () != 1)
			if ($this->population->getPriests () / $this->population->getTotalPopulation () * 100 <= 0.25 / 100)
				if ($this->population->getSlaves () / $this->population->getTotalPopulation () * 100 <= 2 / 100) {
					$this->gameResources->setUnhappiness(true);
					echo ' the population is angry ';}
	}
	public function calcWealth() {
		// WEALTH
		$potmod = 0;
		if ($this->technology->getPottery ())
			$potmod = 2;
		$WealthProd = $this->population->getCraftsmen () * (10 + $potmod);
		$this->gameResources->setWealth ( $this->gameResources->getWealth () + $WealthProd );
	
		echo ' current wealth: ' . $this->gameResources->getWealth();
	}
	public function calcCaravan(){
		// CARAVAN CALCULATION
		if ($this->gameResources->getWealth () >= 550)
			$this->gameResources->incCaravans();
		echo ' caravan sent';
	}
	public function calcBuildings(){
		// BUILDING
		if($this->population->getPriests () >= 10 & $this->gameResources->getWealth () >= 550 & $this->population->getPeasants () >= 1000) {
			$this->buildings->buildTemple();
			echo ' temple built';
		}
		if($this->gameResources->getWealth () >= 850 & $this->population->getPeasants () >= 1500) {	
			$this->buildings->buildPalace();
			echo ' palace built';
		}
		if($this->gameResources->getWealth () >= 1150 & $this->population->getPeasants () >= 1900) {	
			$this->buildings->buildMonuments();
			echo ' monuments built';
		}
	}
	public function calcFoodPop(){
		// FOOD PRODUCTION
		$scribesInfulence=(0.0277777778 * 5/100*$this->population->getScribes () );
		if($scribesInfulence > 0.0277777778)
			$scribesInfulence=0.0277777778;
		$foodProd = floor($this->population->getPeasants() * (($this->gameResources->getUnhappiness())?3/4:1) * (1.111111111 + $scribesInfulence));

		echo ' food produced: ' . $foodProd; 
		echo "<script>project.alert('Food Produced: $foodProd');</script>";
		
		// FOOD CONSUMPTION
		$foodCons = $this->population->getTotalPopulation();

		echo ' food consumed: '.$foodCons;
		// FOOD REMAINING
		if($this->technology->getPottery())
			$this->gameResources->setFood($this->gameResources->getFood()-$foodCons+$foodProd);
		else 
			$this->gameResources->setFood($foodProd-$foodCons);

		echo ' food remaining: '.$this->gameResources->getFood();
		// POPULATION VARIATION
		if ($this->gameResources->getFood()>=0)
			$this->population->setTotalPopulation(ceil($this->population->getTotalPopulation()+$foodProd*2));
		else{
			$LostPop = ceil($this->gameResources->getFood()*2);
			$this->population->setTotalPopulation($this->population->getTotalPopulation()+$LostPop);
			$this->ClassesLossesFromFood(-($LostPop));
		}
		echo ' population: '. $this->population->getTotalPopulation();
	}
	public function calcScore() {
		// SCORE CALCULATION		
		$score = 1;
		// TECH
		if ($this->technology->getGranary())
			$score +=0.5;
		if ($this->technology->getPottery())
			$score +=0.5;
		if ($this->technology->getWriting())
			$score +=0.5;
		// WEALTH
		$score += ceil(($this->gameResources->getWealth ()/500.0* 0.25)*2)/2;
		// BUILDING
		$buildingScore=($this->buildings->getTemple() + $this->buildings->getPalace() + $this->buildings->getMonuments())*0.125;
		$score += ($buildingScore > 0.5) ? 0.5: $buildingScore;
		// POP
		$score += $this->population->getTotalPopulation()/50*0.03125;
		// UNHAPPINESS
		$score+= ($this->gameResources->getUnHappiness())?0:0.5;
		$this->gameResources->setScore ($score);
	}
}

?>