<?php 
require $paths["app"] . "Table" . DS . "backupSql.php";
site_head(null, array()); 
?>
<div class="right main_content">
	<!-- LATEST EPISODES -->
	<div class="section">
	<div class="flash announcment" style="margin-bottom:20px">
		We're still adding new series, you can help us by suggesting your favorite ones 
		<a href="<?= getLink("contact") ?>">here</a>.
	</div>
		<div class="row">
			<div class="title_1" style="display:inline-block">latest episodes</div>
			<div class="direction_nav">
				<i class="icon ion-arrow-left-b prev"></i>
				<i class="icon ion-arrow-right-b next"></i>
			</div>
		</div>
		<div class="row">
			<?php $episodes = \App\Table\Everything::getLatestEpisodes(15)->fetchAll(); ?>
			<div class="episodes_list" style="margin:0;">
				<ul class="slides">
					<?php foreach($episodes as $e): ?>
					<li style="width:200px;float:left;margin-right:15px">
						<?php
						$season = ($e->num_season < 10) ? "0".$e->num_season : $e->num_season;
						$episode = ($e->num_episode < 10) ? "0".$e->num_episode : $e->num_episode;
						?>
						<a href="<?php echo getLink("watch",["title"=>$e->name_series, "id_series"=>$e->id_series, "season"=>$e->num_season, "episode"=>$e->num_episode]) ?>" class="episode_media">
							<div class="img">
								<img src="<?php echo ($e->episode_image !== "none") ? $e->episode_image : $e->image ?>" alt="episode image">
							</div>
							<div class="info">
								<div class="title"><?php echo $e->name_series ?></div>
								<div class="episode"><?php echo "Season " . $e->num_season ." - Episode " . $e->num_episode?></div>
							</div>
						</a>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>

	<!-- BROWSE -->
	<div class="section">
		<div class="row">
			<div class="filter_container">
				<div class="title_1" style="float:left">browse</div>
				<div class="browse_filter">
					<div class="filter_item active">Recent</div>
					<div class="filter_item">popular</div>
					<div class="filter_item">best rated</div>
					<div class="line"></div>
				</div>
			</div>
		</div>
		<div class="row">
			<?php $series = \App\Table\Everything::getSeries("release_date")->fetchAll();  ?>
			<ul class="series_list">
				<?php foreach($series as $s) : ?>
				<li class="single_series">
					<a href="<?php echo getLink("",["title"=>$s->name_series, "id"=>$s->id_series]) ?>">
						<div class="img">
							<img src="<?php echo $s->image ?>" alt="image">
							<div class="hover">
								<i class="icon ion-play"></i>
							</div>
						</div>
						<div class="info">
							<div class="title"><?php echo $s->name_series; ?></div>
							<em class="category"><?php echo explode(",", $s->genres)[0] ?></em>
						</div>
					</a>
				</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>