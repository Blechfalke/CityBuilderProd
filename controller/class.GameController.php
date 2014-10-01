<?php
require_once __ROOT__ . 'model/class.Building.php';
require_once __ROOT__ . 'model/class.GameResources.php';
require_once __ROOT__ . 'model/class.Population.php';
require_once __ROOT__ . 'model/class.Technology.php';
class GameController {
	private $round;
	private $buildings;
	private $gameResources;
	private $population;
	private $technology;
	
	function __construct() {
		$this->round = 1;
		$this->buildings = new Building();
		$this->gameResources = new GameResources();
		$this->population = new Population();
		$this->technology = new Technology();
	}
	function getRound() {
		return $this->round;
	}
	function nextRound() {
		$this->round ++;
	}
	function getBuildings() {
		return $this->buildings;
	}
	function getGameResources() {
		return $this->gameResources;
	}
	function getPopulation() {
		return $this->population;
	}
	function getTechnology() {
		return $this->technology;
	}
		
	function calculateRound() {
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
				echo '!!!!!!!!!!!!!!!!!! you\'ve lost !!!!!!!!!!!!!!!!!';
				$this->round= 1000;
			}
		}
		$this->nextRound ();
	}
	function calcInvasion() {
		if ($this->population->getSoldiers () / $this->population->getTotalPopulation () * 100 <= 2.5 / 100) {
			// those two var will be saved in the db later
			$LostPop = ceil(((3 - $this->population->getSoldiers () / $this->population->getTotalPopulation () * 100) * 5) * $this->population->getTotalPopulation () / 100);
			$LostWealth = ((3 - $this->population->getSoldiers () / $this->population->getTotalPopulation () * 100) * 5) * $this->population->getTotalPopulation () / 100;
			
			$this->population->setTotalPopulation ( $this->population->getTotalPopulation () - $LostPop );
			$this->gameResources->setWealth ( $this->gameResources->getWealth () - $LostPop );
			echo 'invasion pop lost: '.$LostPop.' wealth lost: '.$LostWealth;
			// TODO
			$this->ClassesLossesFromInv($LostPop);
		}
	}
	function ClassesLossesFromInv( $LostPop){
		$array = array(
				$this->population->getSoldiers(),
				$this->population->getPeasants(),
				$this->population->getSlaves(),
				$this->population->getScribes(),
				$this->population->getPriests(),
				$this->population->getKings(),
		);
		$array = $this->ClassesLossesFromInvasion($array,0, $LostPop);
		$this->population->setSoldiers($array[0]);
		$this->population->setPeasants($array[1]);
		$this->population->setSlaves($array[2]);
		$this->population->setScribes($array[3]);
		$this->population->setPriests($array[4]);
		$this->population->setKings($array[5]);
	}
	function ClassesLossesFromInvasion($array, $class, $LostPop){

		if ($array[$class]<$LostPop)
		{
			$LostPop = $LostPop-$array[$class];
			$array[$class] = 0;
			$class++;
			if ($class < 6)
				$array = $this->ClassesLossesFromInvasion($array, $class, $LostPop);
		}
		else{
			$array[$class]=$array[$class]- $LostPop;
		}
		return $array;
	}
	function calcUnhappiness() {
		$this->gameResources->setUnhappiness(false);
		if ($this->population->getKings () != 1)
			if ($this->population->getPriests () / $this->population->getTotalPopulation () * 100 <= 0.25 / 100)
				if ($this->population->getSlaves () / $this->population->getTotalPopulation () * 100 <= 2 / 100) {
					$this->gameResources->setUnhappiness(true);
					echo ' the population is angry ';}
	}
	function calcWealth() {
		$potmod = 0;
		if ($this->technology->getPottery ())
			$potmod = 2;
		$WealthProd = $this->population->getCraftsmen () * (10 + $potmod);
		$this->gameResources->setWealth ( $this->gameResources->getWealth () + $WealthProd );
	
		echo ' current wealth: ' . $this->gameResources->getWealth();
	}
	function calcCaravan(){
		if ($this->gameResources->getWealth () >= 550)
			$this->gameResources->incCaravans();
		echo ' caravan sent';
	}
	function calcBuildings(){
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
	function calcFoodPop(){
		// FOOD PRODUCTION
		$scribesInfulence=(0.0277777778 * 5/100*$this->population->getScribes () );
		if($scribesInfulence > 0.0277777778)
			$scribesInfulence=0.0277777778;
		$foodProd = floor($this->population->getPeasants() * (($this->gameResources->getUnhappiness())?3/4:1) * (1.111111111 + $scribesInfulence));

		echo ' food produced: '.$foodProd;
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
		else
			$this->population->setTotalPopulation(ceil($this->population->getTotalPopulation()+$this->gameResources->getFood()*2));

		echo ' population: '. $this->population->getTotalPopulation();
	}
	function calcScore() {
		$score = 1;
		//tech
		if ($this->technology->getGranary())
			$score +=0.5;
		if ($this->technology->getPottery())
			$score +=0.5;
		if ($this->technology->getWriting())
			$score +=0.5;
		//wealth
		$score += ceil(($this->gameResources->getWealth ()/500.0* 0.25)*2)/2;
		//building
		$buildingScore=($this->buildings->getTemple() + $this->buildings->getPalace() + $this->buildings->getMonuments())*0.125;
		$score += ($buildingScore > 0.5) ? 0.5: $buildingScore;
		//pop
		$score += $this->population->getTotalPopulation()/50*0.03125;
		//unhappiness
		$score+= ($this->gameResources->getUnHappiness())?0:0.5;
		$this->gameResources->setScore ($score);
	}
}

?>
