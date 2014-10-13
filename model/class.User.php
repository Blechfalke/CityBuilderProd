<?php

class User {
	
	public $id_user;
	public $username;
	private $_password;
	public $admin;
	
	public function __construct($username,
								$password,
								$admin){
		$this->username = $username;
		$this->setPassword($password);
		$this->admin = $admin;
	}
	
	public function getPassword(){
		return $this->_password;
	}
	
	public function setPassword($password){
		$this->_password = sha1($password);
	}
	
}

?>