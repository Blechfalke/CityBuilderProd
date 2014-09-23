<?php
class Building{
	private $temple = 0;
	private $palace = 0;
	private $monuments = 0;
	
	public function getTemple(){
		return $this->temple;
	}
	
	public function getPalace(){
		return $this->palace;
	}

	public function getMonuments(){
		return $this->monuments;
	}
	
	public function setTemple($temple){
		$this->temple = $temple;
	}
	
	public function setPalace($palace){
		$this->palace = $palace;
	}
	
	public function setMonuments($monuments){
		$this->monuments = $monuments;
	}
	
	public function buildTemple(){
		$this->temple += 1;
	}
	
	public function buildPalace(){
		$this->palace += 1;
	}
	
	public function buildMonuments(){
		$this->monuments += 1;
	}
}

?>