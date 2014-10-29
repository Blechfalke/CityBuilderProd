<?php
class SingleGameHistoric {
	private $playerID;
	private $mapZone;
	private $gameModeId;
	private $turns;

	public function __construct($playerID, $mapZone,$gameModeId) {
		$this->playerID = $playerID;
		$this->mapZone = $mapZone;
		$this->gameModeId = $gameModeId;
	}
	
	public function appendTurn(Turn $turn){
		$this->turns[] = $turn;
	}
	
	public function getPlayerID() {
		return $this->playerID;
	}
	public function getMapZone() {
		return $this->mapZone;
	}
	public function getGameModeId() {
		return $this->gameModeId;
	}
	public function getTurns(){
		return $this->turns;
	}
	public function setPlayerID($playerName) {
		$this->playerID = $playerName;
	}
	public function setMapZone($mapZone) {
		$this->mapZone = $mapZone;
	}
	public function setGameModeId($gameModeId) {
		$this->gameModeId = $gameModeId;
	}
	public function setTurns($turns){
		$this->turns = $turns;
	}
}
?>