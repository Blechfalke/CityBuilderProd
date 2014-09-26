<?php

require_once __ROOT__ . 'model/class.Building.php';
require_once __ROOT__ . 'model/class.GameResources.php';
require_once __ROOT__ . 'model/class.Population.php';
require_once __ROOT__ . 'model/class.Technology.php';

class GameController{
	
	private $round;
	private $buildings;
	private $gameResources;
	private $population;
	private $technology;
	
	function __construct(){
		$this->round = 1;
		$this->buildings = new Building();
		$this->gameResources = new GameResources();
		$this->population = new Population();
		$this->technology = new Technology();
	}
	
	function getRound(){
		return $this->round;
	}
	
	function nextRound(){
		$this->round++;	
	}
	
	function getBuildings(){
		return $this->buildings;
	}
	
	function getGameResources(){
		return $this->gameResources;
	}

	function getPopulation(){
		return $this->population;
	}
	
	function getTechnology(){
		return $this->technology;
	}
	
	function calculateRound(){
		
		$this->population->updatePopulation(isset($_POST['kings']) ? $_POST['kings'] : 0,
											isset($_POST['priests']) ? $_POST['priests'] : 0,
											isset($_POST['craftsmen']) ? $_POST['craftsmen'] : 0,
											isset($_POST['scribes']) ? $_POST['scribes'] : 0,
											isset($_POST['soldiers']) ? $_POST['soldiers'] : 0,
											isset($_POST['peasants']) ? $_POST['peasants'] : 0,
											isset($_POST['slaves']) ? $_POST['slaves'] : 0);
		
		$this->nextRound();
	}
	function calculateScore(){
		return 0;
	}
}

?>