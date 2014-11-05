<?php
require_once 'controllerconfig.php';
require_once LOCATOR . '/dal/class.MySQLConnector.php';
require_once LOCATOR . '/controller/class.GameController.php';

/**
 * 
 * The History controller can be used to calculate the outcome of a game with the historic extracted from the database
 * 
 * It's not implemented.
 *
 */
class HistoryController {
	private $_gameController;
	private $_singleGameHistoric;
	private $_textHistory;
	private $_scTechnology;
	private $_scWealth;
	private $_scBuildings;
	private $_scPopulation;
	private $_scHappiness;
	private $_scTotal;
	public function getTextHistory() {
		return $this->_textHistory;
	}
	public function getScTechnology() {
		return $this->_scTechnology;
	}
	public function getScWealth() {
		return $this->_scWealth;
	}
	public function getScBuildings() {
		return $this->_scBuildings;
	}
	public function getScPopulation() {
		return $this->_scPopulation;
	}
	public function getScHappiness() {
		return $this->_scHappiness;
	}
	public function getScTotal() {
		return $this->_scTotal;
	}
	private function _build(SingleGameHistoric $singleGameHistoric) {
		$this->gameController = new GameController ();
		$this->singleGameHistoric = $singleGameHistoric;
		$this->_textHistory = "";
		
		foreach ( $this->singleGameHistoric->getTurns () as $turn ) {
			
			$this->gameController->calculateRoundForScorePage ( $turn->getPopulation (), $turn->getTechnology (), $this->singleGameHistoric->getMapZone () );
			
		}
	 	$scoresArray = $this->gameController->getGameResources ()->getScore();
		$this->_scTechnology = $scoresArray["tech"];
		$this->_scWealth = $scoresArray["wealth"];
		$this->_scBuildings = $scoresArray["building"];
		$this->_scPopulation = $scoresArray["population"];
		$this->_scHappiness = $scoresArray["happiness"];
		$this->_scTotal = 1 + $this->_scTechnology + $this->_scWealth + $this->_scBuildings + $this->_scPopulation + $this->_scHappiness;
	}
	public function __construct($singleGameHistoricOrGameDbId) {
		if (is_int ( $singleGameHistoricOrGameDbId )) {
			
			$conn = new MySQLConnector ();
			$singleGameHistoricOrGameDbId = $conn->getGameHistoryFromID ( $singleGameHistoricOrGameDbId );
		}
		$this->_build ( $singleGameHistoricOrGameDbId );
	}
}

?>