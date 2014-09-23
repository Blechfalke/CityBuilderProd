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
		$_GET['kings'];
		// do something useful
	}
}

?>