<?php
namespace App\Table;
class Message{
	private $name;
	private $email;
	private $subject;
	private $message;

	public function __construct($name, $email, $subject, $message){
		$this->name = $name;
		$this->email = $email;
		$this->subject = $subject;
		$this->message = $message;
	}

	public function sendMessage(){
		\App\App::getDB()->query("INSERT INTO messages(name, email, subject, message) VALUES(?,?,?,?)", 
			[
				$this->name,
				$this->email,
				$this->subject,
				$this->message
			]
		);
	}
}