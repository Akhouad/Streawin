<?php
namespace Admin\Table;

class NewSeries{
	private $imdb_id, $name, $genres, $release_date, $synopsis, $runtime, $rate, $image;

	public function __construct($imdb_id, $name, $genres, $release_date, $synopsis, $runtime, $rate, $image){
		$this->imdb_id = $imdb_id;
		$this->name = $name;
		$this->genres = $genres;
		$this->release_date = $release_date;
		$this->synopsis = $synopsis;
		$this->runtime = $runtime;
		$this->rate = $rate;
		$this->image = $image;
	}

	public function addSeries(){
		\App\App::getDB()->query("INSERT INTO series(name_series, release_date, synopsis, rate, genres, image, runtime, imdb_id) VALUES(?,?,?,?,?,?,?,?)",
			[$this->name, $this->release_date, $this->synopsis, $this->rate, $this->genres, $this->image, $this->runtime, $this->imdb_id]);

		// $lastId = \App\App::getDB()->getPDO()->lastInsertId();

		// $cover_name = substr($this->cover["name"], 0, strrpos($this->cover["name"], "."));
		// $cover_ext = substr($this->cover["name"], strrpos($this->cover["name"], "."), strlen($this->cover["name"]) - strrpos($this->cover["name"], ".") );
		// \App\App::getDB()->query("INSERT INTO covers(name_cover, ext_cover, id_series) VALUES(?, ?, ?)",
		// 	[sha1($cover_name), $cover_ext, $lastId]);
		// $upload2 = uploadFile('cover', "public/img/series_covers", $this->cover["name"], 2000000, array('png','gif','jpg','jpeg') );
	}
}