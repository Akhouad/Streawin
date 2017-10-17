<?php
if(empty($_GET["category"])) { header("Location: " . getLink("404")) ; die(); }
$category = $_GET["category"];
$series = \App\Table\Everything::series_by_category($category)->fetchAll();
$keywords = [];
foreach($series as $k){
	array_push($keywords, $k->name_series);
	array_push($keywords, $k->genres);
	array_push($keywords, $category);
}
site_head("Search ".$category, $keywords);
?>
<div class="right main_content" style="margin-top:40px">
	<div class="section">
		<div class="title_1">series by category : <?php echo str_replace("-", " ", $category) ?></div>
		
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