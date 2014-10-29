<?php
class GameResources {
	private $wealth;
	private $food;
	private $caravans;
	private $unhappiness;
	private $score;
	public function __construct() {
		$wealth = 0;
		$food = 0;
		$caravans = 0;
		$unhappiness = true;
		$score = array (
				'tech' => 0,
				'wealth' => 0,
				'building' => 0,
				'population' => 0,
				'happiness' => 0 
		);
	}
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
	public function getScore() {
		return $this->score;
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
	public function incCaravans() {
		$this->caravans ++;
	}
	public function setUnhappiness($unhappiness) {
		$this->unhappiness = $unhappiness;
	}
	public function setScore($score) {
		$this->score = $score;
	}
}
?>