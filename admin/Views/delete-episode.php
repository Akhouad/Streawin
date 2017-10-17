<?php
if(! isset($_GET) || strlen($_GET["id_episode"]) === 0){
	header("Location: " . getLink("home",[],true));
}
$id_episode = $_GET["id_episode"];
$id_series = $_GET["id_series"];
\admin\Table\Everything::deleteEpisode($id_episode);
header("Location: " . getLink("episodes",["page"=>"series", "id_series"=>$id_series], true));

?>