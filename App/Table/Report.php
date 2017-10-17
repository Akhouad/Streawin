<?php
namespace App\Table;
class Report{
	private $name;
	private $message;
	private $id_episode;

	public function __construct($name, $message, $id_episode){
		$this->name = $name;
		$this->message = $message;
		$this->id_episode = $id_episode;
	}

	public function sendReport(){
		\App\App::getDB()->query("INSERT INTO reports(author, message, id_episode) VALUES(?,?,?)",
			[$this->name, $this->message, $this->id_episode]);
	}
}