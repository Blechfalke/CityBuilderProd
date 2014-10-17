<?php
class Turn {
	private $population;
	private $technology;

	public function __construct(Population $pop, Technology $tech) {
		$this->population = $pop;
		$this->technology = $tech;
	}

	public function getPopulation() {
		return $this->population;
	}
	public function getTechnology() {
		return $this->population;
	}
	
	public function setPopulation(Population $population) {
		$this->population = $population;
	}
	public function setTechnology(Technology $technology) {
		$this->technology = $technology;
	}
}
?>
