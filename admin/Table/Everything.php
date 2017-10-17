<?php
namespace Admin\Table;

class Everything{

	public static function showAllSeries($limit){
		return \App\App::getDB()->query("SELECT * FROM series s ORDER BY id_series DESC LIMIT {$limit}");
	}

	public static function showAllEpisodes($limit){
		return \App\App::getDB()->query("SELECT e.*, s.* 
			FROM episodes e INNER JOIN series s ON s.imdb_id = e.imdb_id 
			ORDER BY e.id_episode ASC LIMIT {$limit}");
	}

	public static function editSeries($name, $category, $release_date, $synopsis, $id_series){
		\App\App::getDB()->query("UPDATE series SET name_series = ?, id_category = ?, release_date = ?, synopsis = ? WHERE id_series = ?",
			[$name, $category, $release_date, $synopsis, $id_series]);
	}

	public static function editImages($name, $id_series){
		$name_image = substr($name, 0, strrpos($name, "."));
		$ext_image = substr($name, strrpos($name, "."), strlen($name) - strrpos($name, ".") );

		\App\App::getDB()->query("UPDATE images SET name_image = ?, ext_image = ? WHERE id_series = ?",[sha1($name_image), $ext_image, $id_series], true);
		$upload1 = uploadFile('image', "public/img/series_images", $name, 2000000, array('png','gif','jpg','jpeg') );
	}

	public static function editCovers($name, $id_series){
		$name_cover = substr($name, 0, strrpos($name, "."));
		$ext_cover = substr($name, strrpos($name, "."), strlen($name) - strrpos($name, ".") );

		\App\App::getDB()->query("UPDATE covers SET name_cover = ?, ext_cover = ? WHERE id_series = ?",[sha1($name_cover), $ext_cover, $id_series], true);
		$upload2 = uploadFile('cover', "public/img/series_covers", $name, 2000000, array('png','gif','jpg','jpeg') );
	}

	public static function addSeason($season, $id_series){
		\App\App::getDB()->query("INSERT INTO seasons(id_series, num_season) VALUES(?,?)",[$id_series, $season]);
	}

	public static function addEpisode($imdb_id, $num_episode, $title_episode, $num_season, $image, $original_image, $synopsis, $date){
		$d = \App\App::getDB()->query("SELECT * FROM episodes WHERE imdb_id = ? AND num_season = ? AND num_episode = ?", 
			[$imdb_id, $num_season, $num_episode])->fetchAll();
		if($d){
			\App\App::getDB()->query("UPDATE episodes 
						SET num_episode = ?, num_season = ?, title_episode = ?, episode_image = ?, original_image = ?, synopsis = ?, airdate = ?
						WHERE imdb_id = ?",
						[$num_episode, $num_season, $title_episode, $image, $original_image, $synopsis, $date, $imdb_id]);
		}else{
			\App\App::getDB()->query("INSERT INTO episodes(imdb_id, num_episode, title_episode, num_season, episode_image, original_image, synopsis, airdate) 
						VALUES(?,?,?,?,?,?,?,?)",
						[$imdb_id, $num_episode, $title_episode, $num_season, $image, $original_image, $synopsis, $date]);
		}
	}

	public static function editLinks($id_episode, $links){
		\App\App::getDB()->query("DELETE FROM links WHERE id_episode = ?",[$id_episode]);
		foreach($links as $link){
			if(strlen($link) > 0){
				\App\App::getDB()->query("INSERT INTO links(id_episode, link) VALUES(?,?)",[$id_episode, $link]);				
			}
		}
		echo '<div class="alert alert-success">Links updated successfully.</div>';
	}

	public static function deleteEpisode($id_episode){
		\App\App::getDB()->query("DELETE FROM episodes WHERE id_episode = ?",[$id_episode]);
	}

	public static function addMedia($media_name, $id_series){
		\App\App::getDB()->query("INSERT INTO media(media_name, id_series) VALUES(?,?)",[$media_name, $id_series]);
	}

	public static function addTrailer($trailer, $imdb_id){
		\App\App::getDB()->query("INSERT INTO trailers(imdb_id, code_video) VALUES(?, ?)",[$imdb_id, $trailer]);
	}

	public static function addCast($imdb_id, $person, $character, $image, $original_image){
		$d = \App\App::getDB()->query("SELECT * FROM `cast` WHERE `imdb_id` = ? AND `person` = ? AND `character_` = ?",[$imdb_id, $person, $character]);
		if(!$d->fetch()){
			\App\App::getDB()->query("INSERT INTO `cast`(`person`, `character_`, `image`, `original_image`, `imdb_id`) VALUES(?,?,?,?,?)", 
				[$person, $character, $image, $original_image, $imdb_id]);
		}else{
			\App\App::getDB()->query("UPDATE `cast` SET `image` = ?, `original_image` = ? 
				WHERE `imdb_id` = ? AND `person` = ? AND `character_` = ?",
				[$image, $original_image, $imdb_id, $person, $character]);
		}
	}

	public static function getSeasons($id_series){
		return \App\App::getDB()->query("SELECT distinct num_season 
			FROM episodes WHERE imdb_id = (select imdb_id FROM series WHERE id_series = ?)", 
			[$id_series]);
	}

	public static function episodesBySeries($id_series){
		return \App\App::getDB()->query("SELECT distinct e.*, s.* 
			FROM episodes e INNER JOIN series s ON s.imdb_id = e.imdb_id 
			WHERE e.imdb_id = (select imdb_id from series where id_series = ?)
			ORDER BY e.num_season, e.num_episode ASC", 
			[$id_series]);
	}

	public static function nextEpisode($id_episode){
		$req = \App\App::getDB()->query("SELECT * FROM episodes WHERE id_episode = ?", [$id_episode]);
		$current = $req->fetch();
		$req = \App\App::getDB()->query("SELECT * FROM episodes
			WHERE num_episode > ? AND num_season = ? AND imdb_id = ?
			ORDER BY num_episode ASC
			LIMIT 1",
			[$current->num_episode, $current->num_season, $current->imdb_id]
		);
		$next = $req->fetch();
		return $next;
	}

	public static function prevEpisode($id_episode){
		$req = \App\App::getDB()->query("SELECT * FROM episodes WHERE id_episode = ?", [$id_episode]);
		$current = $req->fetch();
		$req = \App\App::getDB()->query("SELECT * FROM episodes
			WHERE num_episode < ? AND num_season = ? AND imdb_id = ?
			ORDER BY num_episode DESC
			LIMIT 1",
			[$current->num_episode, $current->num_season, $current->imdb_id]
		);
		$next = $req->fetch();
		return $next;
	}
}