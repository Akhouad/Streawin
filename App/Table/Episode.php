<?php
namespace App\Table;
class Episode extends Season{
	private $series;
	private $season;
	private $num_episode;

	public function __construct($series, $season, $num_episode){
		$this->series = $series;
		$this->season = $season;
		$this->num_episode = $num_episode;
	}

	public function getURL(){
		return getLink("series",["id"=>$this->series->get("id"), "season"=>$this->season->get("num_season"), "episode"=>$this->num_episode]);
	}

}