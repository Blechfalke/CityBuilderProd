<?php
require_once ($_SERVER['DOCUMENT_ROOT'] . '/git/CityBuilderProd/config.php');
//require_once '../config.php';
require_once LOCATOR . '/model/class.User.php';
require_once LOCATOR . '/model/class.SingleGameHistoric.php';
class MySQLConnector {
	// const HOST = 'localhost';
	// const PORT = '8889';
	// const DBNAME = 'pyramidgame';
	// const USER = 'pyramidgame';
	// const PWD = 'test123';
	const HOST = 'db4free.net';
	const PORT = '3306';
	const DBNAME = 'pyramiddb';
	const USER = 'pyramidaccess';
	const PWD = 'pyramidAccess605';
	private $_conn;

	public function __construct() {
		try {
			$this->_conn = new PDO("mysql:host=" . self::HOST . ";port=" . self::PORT . ";dbname=" . self::DBNAME, self::USER, self::PWD);
		} catch (PDOException $ex) {
			trigger_error($ex->getMessage());
		}
	}

	public function getError() {
		if ($this->_conn->errorCode() != '00000')
			return 'Query failed!';
		return false;
	}

	public function checkCredentials($username, $password) {
		$query = "SELECT * FROM Users WHERE username='" . $username . "' AND password='" . sha1($password) . "';";
		$result = $this->_conn->query($query);
		
		if ($this->getError())
			trigger_error($this->getError());
		
		$row = $result->fetch();
		
		if (! $row)
			return false;
		
		$user = new User($row ['username'], $row ['password'], $row ['admin']);
		$user->id_user = $row ['id_user'];
		return $user;
	}
	public function getIdByUsername($username) {
		$query = "SELECT id_user FROM Users WHERE username='" . $username . "';";
		$result = $this->_conn->query($query);
	
		if ($this->getError())
			trigger_error($this->getError());
	
		$row = $result->fetch();
	
		if (! $row)
			return false;
	
		return $row[0];
	}

	public function setGameMode($newGameMode) {		
		$query = "UPDATE CurrentGameMode 
					SET id_fk_CurrentGameMode=?
					WHERE id='1'";
		
		$q = $this->_conn->prepare($query);
		$q->execute(array($newGameMode));
		
		if ($this->getError())
			trigger_error($this->getError());
		
		return true;
	}
	public function getGameMode() {		
		$query = "SELECT id_fk_CurrentGameMode FROM CurrentGameMode
					WHERE id='1'";
		$result = $this->_conn->query($query);
		
		if ($this->getError())
			trigger_error($this->getError());
		
		$row = $result->fetch();
		
		if (! $row)
			return false;
		
		return $row[0];
	}
	
	public function insertHistory(SingleGameHistoric $singleGameHistoric) {
		$query = "INSERT INTO Game(city_type, id_gamemodes, Users_id_user) VALUES(?, ?, ?);";
		$queryID = "SELECT @@IDENTITY";
		switch ($singleGameHistoric->getmapZone()){
		case 'zone_2':
			$city_type = 2;
			break;
		case 'zone_3':
			$city_type = 3;
			break;
		default:
			$city_type = 1;
			break;
		}
		$gameMode = $singleGameHistoric->getGameModeId();
		$user_id = $this->getIdByUsername($singleGameHistoric->getPlayerName());
		echo '::'.$city_type.'::'.$gameMode.'::'.$user_id.'::';
		
		$q = $this->_conn->prepare($query);
		$q->execute(array($city_type,$gameMode,$user_id));
		//retrieve the last ID
		$result = $this->_conn->query($queryID);
		$idGame = $result->fetch();
		$idGame = $idGame[0];
		//EXECUTE QUERY FOR THE GAME AND RETRIVE THE ID
		$techstate = array( 'pottery'=>0,'granary'=>0,'writing'=>0);
		$turnNB = 1;
		foreach($singleGameHistoric->getTurns() as $t){
			//QUERY FOR EACH TURNS
			$popTotal = $t->getPopulation()->getTotalPopulation();
			$popKings = $t->getPopulation()->getKings();
			$popPriests = $t->getPopulation()->getPriests();
			$popCraftsmen = $t->getPopulation()->getCraftsmen();
			$popScribes = $t->getPopulation()->getScribes();
			$popSoldiers = $t->getPopulation()->getSoldiers();
			$popPeasants = $t->getPopulation()->getPeasants();
			$popSlaves = $t->getPopulation()->getSlaves();
			$technology ='NONE';
			if($techstate['pottery']==0 && $t->getTechnology()->getPottery()){
				$technology = 'pottery';$techstate['pottery']=1;}
			elseif($techstate['granary']==0 && $t->getTechnology()->getGranary()){
				$technology = 'granary';$techstate['granary']=1;}
			elseif($techstate['writing']==0 && $t->getTechnology()->getGranary()){
				$technology = 'writing';$techstate['writing']=1;}
				
			// EXECUTE QUERY FOR THE TURN
			$query = "INSERT INTO Turns(id_historical, nb_total_pop, nb_kings, nb_priests, nb_scribes, nb_craftsmen, nb_soldiers, nb_peasants, nb_slaves, nb_turns, technology_used) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
			$q = $this->_conn->prepare($query);
			$q->execute(array($idGame,$popTotal,$popKings,$popPriests,$popScribes,$popCraftsmen,$popSoldiers,$popPeasants,$popSlaves,$turnNB,$technology));
			echo $idGame. '  '.$popTotal. '  '.$popKings. '  '.$popPriests. '  '.$popScribes. '  '.$popCraftsmen. '  '.$popSoldiers. '  '.$popPeasants. '  '.$popSlaves. ' TURN '.$turnNB. '  '.$technology;
			$turnNB++;
		}
		
		if ($this->getError())
			trigger_error($this->getError());
	}
}