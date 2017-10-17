<?php
$index = $_POST["index"];
$data = \App\Table\Everything::getSeries($index)->fetchAll();
?>

<?php foreach($data as $s) : ?>
<li class="single_series" style="display:none">
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