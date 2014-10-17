<?php
class SingleGameHistoric {
	private $playerName;
	private $mapZone;
	private $gameMode;
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
	public function getGameMode() {
		return $this->gameMode;
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
	public function setGameMode($gameMode) {
		$this->gameMode = $gameMode;
	}
	public function setTurns($turns){
		$this->turns = $turns;
	}
}
?>