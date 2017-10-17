<?php
if( !isset($_GET) || strlen($_GET["id_series"]) === 0 ) { header("Location: " . getLink("404")); die(); exit(); }

$id_series = $_GET["id_series"];

$data = \App\Table\Everything::seriesById($id_series)->fetch();
if(!$data){ header("Location: " . getLink("")); die(); exit(); }

$series = new \App\Table\Series($id_series);
$info = $series->getInfo()->fetch();

$cover = $series->getCover()->fetch();

$seasons = $series->getSeasons()->fetchAll();
$trailer = $series->getTrailer()->fetch();

$keywords = [
	$info->name_series,
	"series",
	$info->genres
];
site_head($info->name_series, $keywords);
?>
<div class="right" style="margin-top:60px">
	<div class="cover">
		<div class="cover_bg">
			<img src="<?php echo $cover->original_image; ?>" alt="cover image">
		</div>
		<div class="series_image">
			<img src="<?php echo $info->image ?>" alt="series_image">
		</div>
		<div class="series_info">
			<div class="date"><?php echo explode("-", $info->release_date)[0]; ?></div>
			<div class="title"><?php echo $info->name_series; ?></div>
			<div class="rate">
				<img src="<?php echo getFileURL('public' . DS . "dist" . DS . 'img' . DS . "imdb.png") ?>" alt="image">
				<?php 
				$rate = round($info->rate/2);
				for($i=0 ; $i<$rate ; $i++):?>
				<i class="icon ion-star yellow-text" style="margin-right:-4px"></i>
				<?php endfor; ?>
				<?php for($i = 0 ; $i < 5-$rate ; $i++): ?>
				<i class="icon ion-star"></i>
				<?php endfor; ?>
				<span style="margin:0 10px;"><?php echo $info->rate . " / 10" ?></span>
			</div>
			<div class="genres">
				<?php 
				$genres = explode(',', $info->genres);
				foreach($genres as $g){
					echo '<div class="single_genre">' . $g . '</div>';
				}
				?>
			</div>
		</div>
	</div>
	
	<div class="left_side">
		<div class="title_1">seasons</div>
		<ul class="seasons">
			<?php foreach($seasons as $s): ?>
			<li><a href="" class="<?php echo ($s->num_season == 1) ? "active" : "" ?>"><?php echo $s->num_season ?></a></li>
			<?php endforeach; ?>
		</ul>

		<div class="hidden id_series"><?php echo $info->id_series ?></div>
		<ul class="episodes">
			<?php $episodes = $series->episodesBySeason(1)->fetchAll(); ?>
			<?php foreach($episodes as $e): ?>
			<li>
				<a href="<?php echo getLink("watch",["title"=>$info->name_series, "id_series"=>$id_series, "season"=>1, "episode"=>$e->num_episode]) ?>">
					<img src="<?php echo ($e->episode_image !== "none") ? $e->episode_image : $info->image ?>" alt="episode image">
					<span class="episode_number"><?php echo ($e->num_episode < 10) ? "0".$e->num_episode : $e->num_episode; ?></span>
					<span class="episode_title"><?php echo $e->title_episode ?></span>
				</a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<div class="right_side">
		<?php if($info->synopsis): ?>
		<div class="series_synopsis">
			<div class="row"><div class="title_1">synopsis</div></div>
			<?php 
			$syno = $info->synopsis;
			$syno = str_replace("&amp;lt;", "<", $syno);
			$syno = str_replace("&amp;gt;", ">", $syno);
			$syno = str_replace("&amp;quot;", "'", $syno);
			?>
			<p><?php echo $syno; ?></p>
		</div>
		<?php endif;?>

		<?php $cast = \App\Table\Everything::getCast($id_series)->fetchAll();?>
		<?php if($cast): ?>
			<div class="row"><div class="title_1">cast</div></div>
			<ul class="cast" style="margin-bottom:30px;float:left">
				<?php foreach($cast as $c): ?>
				<li>
					<img src="<?php echo $c->image ?>" alt="image">
					<p class="name"><?php echo $c->person ?></p>
				</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>


		<div class="row"><div class="title_1">you may like</div></div>
		<?php require $paths["views"] . "random-series.php" ?>
	</div>
</div>