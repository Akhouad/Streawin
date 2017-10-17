<?php
namespace App\Table;
class Everything{
	public static function getSeries($index){
		if($index === "popular") {
			$req = "SELECT s.*, SUM(e.views) as v
				FROM episodes e INNER JOIN series s ON s.imdb_id = e.imdb_id
				GROUP BY s.id_series
                ORDER BY v DESC";
		}
		else if($index === "best rated") {
			$req = "SELECT * FROM series ORDER BY rate DESC";
		}
		else{
			$req = "SELECT * FROM series ORDER BY release_date DESC";
		}

		return \App\App::getDB()->query($req);
	}

	public static function seriesById($id){
		return \App\App::getDB()->query("SELECT * FROM series WHERE id_series = ?", [$id]);
	}

	public static function getLatestEpisodes($limit){
		return \App\App::getDB()->query("SELECT e.*, s.* FROM episodes e INNER JOIN series s ON s.imdb_id = e.imdb_id ORDER BY airdate DESC LIMIT {$limit}");
	}

	public static function mostSeenEpisodes($limit){
		return \App\App::getDB()->query("SELECT e.*, s.* FROM episodes e INNER JOIN series s ON s.imdb_id = e.imdb_id ORDER BY views DESC LIMIT {$limit}");
	}

	public static function getCast($id){
		return \App\App::getDB()->query("SELECT * FROM cast WHERE imdb_id = (SELECT imdb_id FROM series WHERE id_series = ?)", [$id]);
	}

	public static function randomSeries($id_series, $limit){
		return \App\App::getDB()->query("SELECT * FROM series WHERE id_series != $id_series ORDER BY RAND() LIMIT {$limit}");
	}

	public static function currentEpisode($id_series, $season, $episode){
		return \App\App::getDB()->query("SELECT * FROM episodes 
			WHERE imdb_id = (SELECT imdb_id FROM series WHERE id_series = ?)
			AND num_episode = ? AND num_season = ?",
			[$id_series, $episode, $season]);
	}

	public static function nextEpisode($id_series, $season, $episode){
		return \App\App::getDB()->query("SELECT * FROM episodes 
			WHERE imdb_id = (SELECT imdb_id FROM series WHERE id_series = ?)
			AND num_episode > ? AND num_season = ?
			ORDER BY num_episode ASC
			LIMIT 1",
			[$id_series, $episode, $season]);
	}
	public static function prevEpisode($id_series, $season, $episode){
		return \App\App::getDB()->query("SELECT * FROM episodes 
			WHERE imdb_id = (SELECT imdb_id FROM series WHERE id_series = ?)
			AND num_episode < ? AND num_season = ?
			ORDER BY num_episode DESC
			LIMIT 1",
			[$id_series, $episode, $season]);
	}

	public static function series_by_category($cat){
		return \App\App::getDB()->query("SELECT * FROM series WHERE genres LIKE '%{$cat}%'");
	}

	public static function getGenres(){
		return \App\App::getDB()->query("SELECT genres FROM series");
	}

	public static function getLinks($id){
		return \App\App::getDB()->query("SELECT * FROM links WHERE id_episode = ?",[$id]);
	}

	public static function addView($id_episode){
		$req = \App\App::getDB()->query("SELECT views FROM episodes WHERE id_episode = ?",[$id_episode]);
		$views = $req->fetch();
		$views = $views->views;
		$views += 1;
		\App\App::getDB()->query("UPDATE episodes SET views = ? WHERE id_episode = ?", [$views, $id_episode]);
	}

	public static function addEmail($email, $ip){
		\App\App::getDB()->query("INSERT INTO emails(email, ip) VALUES(?,?)", [$email, $ip]);
	}

	public static function search($name_series){
		return \App\App::getDB()->query("SELECT * FROM series 
			WHERE LCASE(name_series) = ?" , [$name_series]);
	}
}