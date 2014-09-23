<?php
class GameResources {  
	private $wealth = 0;
	private $food = 0;
	private $caravans = 0;
	private $unhappiness = true;
	
	public function getWealth() {
		return $this->wealth;
	}
	
	public function getFood() {
		return $this->food;
	}
	
	public function getCaravans() {
		return $this->caravans;
	}
	
	public function getUnhappiness() {
		return $this->unhappiness;
	}
	
	public function setWealth($wealth) {
		$this->wealth = $wealth;
	}
	
	public function setFood($food) {
		$this->food = $food;
	}
	
	public function setCaravans($caravans) {
		$this->caravans = $caravans;
	}
	
	public function setUnhappiness($unhappiness) {
		$this->unhappiness = $unhappiness;
	}
	
}
?>