<?php
require_once '../model/class.User.php';

class MySQLConnector {
	const HOST = 'localhost';
	const PORT = '8889';
	const DBNAME = 'pyramidgame';
	const USER = 'pyramidgame';
	const PWD = 'test123';
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
	
	public function getUsers(){
		$users = array();
		$query = "SELECT * FROM user;";
		$result = $this->_conn->query($query);
		
		if ($this->getError()) {
			trigger_error($this->getError());
		}
		
		while ($row = $result->fetch()){
			$user = new User($row['firstname'],$row['lastname'],$row['username'],$row['password']);
			$user->createdAt = $row['createdAt'];
			$users[$row['id']] = $user;	
		}
		
		return $users;
	}
	
	public function checkCredentials($username, $password){
		$query = "SELECT * FROM user WHERE username='". $username. "' AND password='".sha1($password)."';";
		$result = $this->_conn->query($query);
		
		if ($this->getError())
			trigger_error($this->getError());
		
		$row = $result->fetch();
		
		if (!$row) return false;
		
		$user = new User($row['firstname'],
							$row['lastname'],
							$row['username'],
							$row['password']);
		$user->id = $row['id'];
		$user->createdAt = $row['createdAt'];
		return $user;
	}
}