<?php
class Technology{
	private $pottery = false;
	private $granary = false;
	private $writing = false;
	
	public function getPottery(){
		return $this->pottery;
	}
	
	public function getGranary(){
		return $this->granary;
	}

	public function getWriting(){
		return $this->writing;
	}
	
	public function setPottery($pottery){
		$this->pottery = $pottery;
	}
	
	public function setGranary($granary){
		$this->granary = $granary;
	}
	
	public function setWriting($writing){
		$this->writing = $writing;
	}
	public function updateTechnology($tech){
		if($tech=="granary")
			$this->granary = true;
		else if ($tech=="writing")
			$this->writing = true;
		else if ($tech=="pottery")
			$this->pottery = true;
	}
}

?>