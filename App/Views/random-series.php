<!-- SERIES YOU MAY LIKE -->
<?php $random_series = \App\Table\Everything::randomSeries($id_series, 6)->fetchAll(); ?>
<ul class="series_list">
<?php foreach($random_series as $r): ?>
	<li class="single_series">
		<a href="<?php echo getLink("",["title"=>$r->name_series, "id"=>$r->id_series]) ?>">
			<div class="img">
				<img src="<?php echo $r->image ?>" alt="image">
				<div class="hover">
					<i class="icon ion-play"></i>
				</div>
			</div>
			<div class="info">
				<div class="title"><?php echo $r->name_series; ?></div>
				<em class="category"><?php echo explode(",", $r->genres)[0] ?></em>
			</div>
		</a>
	</li>
<?php endforeach; ?>
</ul>