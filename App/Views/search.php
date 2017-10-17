<?php
if(!isset($_POST["name_series"])){
	header("Location: ". getLink("404"));
	die();
}
$name_series = $_POST["name_series"];
// $name_series = $_GET["name_series"];

$results = \App\Table\Everything::search($name_series)->fetchAll();
if($results): ?>

<div class="search_result">
	<div class="content">
		<div class="close_popup">Close [x]</div>
		<div class="title_1" style="float:left;width:100%">search results</div>

		<ul class="series_list">
			<?php foreach($results as $s) : ?>
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

<?php else : ?>
	<div class="search_result">
		<div class="content">
			<div class="close_popup">Close [x]</div>
			<div class="title_1" style="float:left;width:100%">search results</div>

			<p style="color:#566270">Not found.</p>
		</div>
	</div>
<?php endif; ?>

<script type="text/javascript">
	
(function(d, w, jq){
	jq(d).ready(function(){
		jq(".search_result .close_popup").on("click", function(e){
			e.preventDefault();
			jq(this).parents(".search_result").fadeOut(200);
		});
	});
})(document, window, jQuery);
</script>