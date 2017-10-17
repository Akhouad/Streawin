<?php
namespace App\Table;

class Series{
	private $id;
	private $title;

	public function __construct($id){
		$this->id = $id;
	}

	public function get($arg){
		return $this->$arg;
	}
	public function getTitle(){
		return $this->title = \App\App::getDB()->query("SELECT name_series from series where id_series = ?", [$this->id])->fetch();
	}

	/**
	  * Gets all seasons' numbers of a series
	*/
	public function getSeasons(){
		return \App\App::getDB()->query("SELECT distinct num_season FROM episodes WHERE imdb_id = (SELECT imdb_id FROM series WHERE id_series = ?)", [$this->id]);
	}

	public function getImage(){
		return \App\App::getDB()->query("SELECT * FROM images WHERE id_series = ?", [$this->id]);
	}

	public function getCover(){
		return \App\App::getDB()->query("SELECT original_image FROM episodes WHERE imdb_id = (SELECT imdb_id FROM series WHERE id_series = ?) AND original_image != 'none' ",
			[$this->id]);
	}

	public function getMedia(){
		return \App\App::getDB()->query("SELECT * FROM media WHERE id_series = ?", [$this->id]);
	}

	public function getInfo(){
		return \App\App::getDB()->query("SELECT * FROM series s WHERE id_series = ?", [$this->id]);
	}

	public function getTrailer(){
		return \App\App::getDB()->query("SELECT * FROM trailers WHERE imdb_id = (SELECT imdb_id FROM series WHERE id_series = ?) ",[$this->id]);
	}

	public function episodesBySeason($season){
		return \App\App::getDB()->query("SELECT distinct num_episode, title_episode, views, num_season, episode_image, synopsis, imdb_id, airdate FROM episodes 
			WHERE num_season = ? AND imdb_id = (SELECT imdb_id FROM series WHERE id_series = ?) ORDER BY num_episode", 
			[$season, $this->id]);
	}
	
}