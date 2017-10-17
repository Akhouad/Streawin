<?php
namespace Admin\Table;

class Season{
	private $id_series;

	public function __construct($id){
		$this->id_series = $id;
	}

	public function getSeasons(){
		return \App\App::getDB()->query("SELECT * FROM seasons WHERE id_series = ?",[$this->id_series]);
	}

	public function getEpisodes($num_season){
		return \App\App::getDB()->query("SELECT e.* FROM episodes e INNER JOIN seasons se ON se.id_season = e.id_season
				INNER JOIN series s ON s.id_series = se.id_series WHERE s.id_series = ? AND se.num_season = ?",
				[$this->id_series, $num_season]);
	}
}