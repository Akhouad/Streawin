<?php
namespace App\Table;
class Season extends Series{
	private $series;
	private $num_season;

	public function __construct($series, $num_season){
		$this->series = $series;
		$this->num_season = $num_season;
	}

	public function get($arg){
		return $this->$arg;
	}

	public function getURL(){
		return getLink("series",["id"=>$this->series->get("id"), "season"=>$this->num_season]);
	}

	/**
	  * Gets all episodes' number & episodes' title of a series
	*/
	public function getEpisodes(){
		return \App\App::getDB()->query("SELECT e.title_episode, e.num_episode 
				FROM series s INNER JOIN seasons se on se.id_series = s.id_series 
				INNER JOIN episodes e on e.id_season = se.id_season 
				WHERE se.id_series = ?", 
				[$this->series->get("id")]
			);
	}
}