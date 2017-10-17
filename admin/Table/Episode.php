<?php
namespace Admin\Table;

class Episode{
	private $id_episode;
	private $id_series = null;

	public function __construct($id_episode){
		$this->id_episode = $id_episode;
	}

	public function getSeriesId(){
		if($this->id_series === null){
			$req = \App\App::getDB()->query("SELECT s.id_series FROM series s INNER JOIN episodes e ON e.imdb_id = s.imdb_id
				WHERE e.id_episode = ?",[$this->id_episode]);
			$this->id_series = $req->fetch()->id_series;
		}
		return $this->id_series;
	}

	public function getInfo(){
		return \App\App::getDB()->query("SELECT * FROM episodes WHERE id_episode = ?", [$this->id_episode]);
	}

	public function insertLinks($links){
		\App\App::getDB()->query("DELETE FROM links WHERE id_episode = ?", [$this->id_episode]);
		foreach($links as $l){			
			\App\App::getDB()->query("INSERT INTO links(id_episode, link) VALUES(?, ?)", [$this->id_episode, $l]);
		}
	}

	public function getLinks(){
		return \App\App::getDB()->query("SELECT * FROM links WHERE id_episode = ?", [$this->id_episode]);
	}

	public function editEpisode($num_episode, $image, $title, $num_season, $synopsis){
		\App\App::getDB()->query("UPDATE episodes 
			SET num_episode = ?, title_episode = ?, num_season = ?, episode_image = ?, synopsis = ?
			WHERE id_episode = ?", 
			[$num_episode, $title, $num_season, $image, $synopsis, $this->id_episode]);
	}
}