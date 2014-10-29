<?php
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/git/CityBuilderProd/config.php');
require_once LOCATOR . '/dal/class.MySQLConnector.php';
require_once LOCATOR . '/controller/class.GameController.php';
class HistoryController {
	private $gameController;
	private $singleGameHistoric;
	private $textHistory;
	private $scTechnology;
	private $scWealth;
	private $scBuildings;
	private $scPopulation;
	private $scHappiness;
	private $scTotal;
	public function getTextHistory() {
		return $this->textHistory;
	}
	public function getScTechnology() {
		return $this->scTechnology;
	}
	public function getScWealth() {
		return $this->scWealth;
	}
	public function getScBuildings() {
		return $this->scBuildings;
	}
	public function getScPopulation() {
		return $this->scPopulation;
	}
	public function getScHappiness() {
		return $this->scHappiness;
	}
	public function getScTotal() {
		return $this->scTotal;
	}
	private function build(SingleGameHistoric $singleGameHistoric) {
		$this->gameController = new GameController ();
		$this->singleGameHistoric = $singleGameHistoric;
		$this->textHistory = "";
		
		foreach ( $this->singleGameHistoric->getTurns () as $turn ) {
			
			$this->gameController->calculateRoundForScorePage ( $turn->getPopulation (), $turn->getTechnology (), $this->singleGameHistoric->getMapZone () );
			// $this->textHistory = $this->textHistory . "Turn " . $turnCount;
			// foreach ( $this->gameController->getNextRoundPopupText () as $textLine )
			// $this->textHistory = $this->textHistory . "<p>" . $textLine . "</p>";
			// $this->textHistory = $this->textHistory . "<hr />";
			
		}
		
		$this->scTechnology = $this->gameController->getGameResources ()->getScore ()["tech"];
		$this->scWealth = $this->gameController->getGameResources ()->getScore ()["wealth"];
		$this->scBuildings = $this->gameController->getGameResources ()->getScore ()["building"];
		$this->scPopulation = $this->gameController->getGameResources ()->getScore ()["population"];
		$this->scHappiness = $this->gameController->getGameResources ()->getScore ()["happiness"];
		$this->scTotal = 1 + $this->scTechnology + $this->scWealth + $this->scBuildings + $this->scPopulation + $this->scHappiness;
	}
	public function __construct($singleGameHistoricOrGameDbId) {
		//if $singleGameHistoricOrGameDbId is int it's an ID>> we get a singleGameHistoric from the DB
		if (is_int ( $singleGameHistoricOrGameDbId )) {
			
			$conn = new MySQLConnector ();
			$singleGameHistoricOrGameDbId = $conn->getGameHistoryFromID ( $singleGameHistoricOrGameDbId );
		}
		$this->build ( $singleGameHistoricOrGameDbId );
	}
}

?>