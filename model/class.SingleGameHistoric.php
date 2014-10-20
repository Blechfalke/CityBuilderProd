<?php
class SingleGameHistoric {
	private $playerName;
	private $mapZone;
	private $gameModeId;
	private $turns;

	public function appendTurn(Turn $turn){
		$this->turns[] = $turn;
	}
	
	public function getPlayerName() {
		return $this->playerName;
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
	public function setPlayerName($playerName) {
		$this->playerName = $playerName;
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