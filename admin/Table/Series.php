<?php
namespace Admin\Table;

class Series{
	private $id;

	public function __construct($id){
		$this->id = $id;
	}

	public function get($arg){
		return $this->$arg;
	}

	public function getURL(){
		return getLink("series",["id"=>$this->id]);
	}

	/**
	  * Gets all seasons' numbers of a series
	*/
	public function getSeasons(){
		return \App\App::getDB()->query("SELECT se.num_season 
				FROM series s INNER JOIN seasons se ON s.id_series = se.id_series 
				WHERE s.id_series = ?", 
				[$this->id]
			);
	}
	public function getInfo(){
		return \App\App::getDB()->query('SELECT *
			FROM series 
			WHERE id_series = ?',[$this->id]);
	}
	
}