<?php
require_once '../config.php';
require_once LOCATOR . '/model/class.User.php';

class MySQLConnector {
// 	const HOST = 'localhost';
// 	const PORT = '8889';
// 	const DBNAME = 'pyramidgame';
// 	const USER = 'pyramidgame';
// 	const PWD = 'test123';
	const HOST = 'db4free.net';
	const PORT = '3306';
	const DBNAME = 'pyramiddb';
	const USER = 'pyramidaccess';
	const PWD = 'pyramidAccess605';
	private $_conn;
	
	public function __construct() {
		try{
			$this->_conn = new PDO ( "mysql:host=" . self::HOST . ";port=" . self::PORT . ";dbname=" . self::DBNAME, self::USER, self::PWD );
		}catch (PDOException $ex){
			trigger_error($ex->getMessage());
		}
	}
	
	public function getError(){
		if ($this->_conn->errorCode() != '00000')
			return 'Query failed!';
		return false;	
	}
	
	public function checkCredentials($username, $password){
		$query = "SELECT * FROM Users WHERE username='". $username. "' AND password='".sha1($password)."';";
		$result = $this->_conn->query($query);
		
		if ($this->getError())
			trigger_error($this->getError());
		
		$row = $result->fetch();
		
		if (!$row) return false;
		
		$user = new User(	$row['username'],
							$row['password'],
							$row['admin']);
							$user->id_user = $row['id_user'];
		return $user;
	}
}