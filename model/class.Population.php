<?php
class Population {
	private $totalPopulation = 1000;
	private $kings = 1;
	private $priests = 2;
	private $craftsmen = 3;
	private $scribes = 4;
	private $soldiers = 5;
	private $peasants = 6;
	private $slaves = 7;
	
	public function getTotalPopulation() {
		return $this->totalPopulation;
	}
	
	public function getKings() {
		return $this->kings;
	}
	
	public function getPriests() {
		return $this->priests;
	}
	
	public function getCraftsmen() {
		return $this->craftsmen;
	}
	
	public function getScribes() {
		return $this->scribes;
	}
	
	public function getSoldiers() {
		return $this->soldiers;
	}
	
	public function getPeasants() {
		return $this->peasants;
	}
	
	public function getSlaves() {
		return $this->slaves;
	}
	
	public function setTotalPopulation($totalPopulation) {
		$this->totalPopulation = $totalPopulation;
	}
	
	public function setKings($kings) {
		$this->kings = $kings;
	}
	
	public function setPriests($priests) {
		$this->priests = $priests;
	}
	
	public function setCraftsmen($craftsmen) {
		$this->craftsmen = $craftsmen;
	}
	
	public function setScribes($scribes) {
		$this->scribes = $scribes;
	}
	
	public function setSoldiers($soldiers) {
		$this->soldiers = $soldiers;
	}
	
	public function setPeasants($peasants) {
		$this->peasants = $peasants;
	}
	
	public function setSlaves($slaves) {
		$this->slaves = $slaves;
	}
	
	public function updatePopulation($kings, $priests, $craftsmen, $scribes, $soldiers, $peasants, $slaves){
		$this->kings = $kings;
		$this->priests = $priests;
		$this->craftsmen = $craftsmen;
		$this->scribes = $scribes;
		$this->soldiers = $soldiers;
		$this->peasants = $peasants;
		$this->slaves = $slaves;
	}
}
?>