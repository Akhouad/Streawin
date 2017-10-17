<?php 
$id_series = $_POST["id_series"];
$series = new \App\Table\Series($id_series);
$title = $series->getTitle()->name_series;
?>
<?php $episodes = $series->episodesBySeason($_POST["season"])->fetchAll();?>
<?php foreach($episodes as $e): ?>
<li>
	<a href="<?php echo getLink("watch",["title"=>$title, "id_series"=>$id_series, "season"=>$_POST["season"], "episode"=>$e->num_episode]) ?>">
		<img src="<?php echo ($e->episode_image !== "none") ? $e->episode_image : $series->getInfo()->fetch()->image ?>" alt="episode image">
		<span class="episode_number"><?php echo ($e->num_episode < 10) ? "0".$e->num_episode : $e->num_episode; ?></span>
		<span class="episode_title"><?php echo $e->title_episode ?></span>
	</a>
</li>
<?php endforeach; ?>