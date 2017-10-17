<?php
namespace Admin\Table;
class Login{
	private $user;
	private $password;

	public function __construct($user, $password){
		$this->user = $user;
		$this->password = $password;
	}

	public function logged(){
		return isset($_SESSION["auth"]);
	}

}