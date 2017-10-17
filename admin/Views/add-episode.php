<?php
if(! isset($_GET) || strlen($_GET["id_series"]) === 0){
	header("Location: " . getLink("home",[],true));
}else{
	$req = \App\App::getDB()->query("SELECT id_series FROM series WHERE id_series = ?",[$_GET["id_series"]]);
	$data = $req->fetch();
	if( !$data ){
		header("Location: " . getLink("home",[],true));	
	}
}
$id_series = $_GET["id_series"];
$series = new \admin\Table\Series($id_series);
$series = $series->getInfo()->fetch();

$season = new \admin\Table\Season($id_series);
$allSeasons = $season->getSeasons()->fetchAll();

if(isset($_POST)){
	$season = (isset($_POST["season"]) && strlen($_POST["season"]) > 0) ? $_POST["season"] : false;
	$episode_number = (isset($_POST["episode_number"]) && strlen($_POST["episode_number"]) > 0) ? $_POST["episode_number"] : false;
	$episode_title = (isset($_POST["episode_title"]) && strlen($_POST["episode_title"]) > 0) ? $_POST["episode_title"] : null;

	$new_season = (isset($_POST["new_season"]) && strlen($_POST["new_season"]) > 0) ? $_POST["new_season"] : false;
	if($new_season && strlen($new_season) > 0){
		\admin\Table\Everything::addSeason($new_season, $id_series);
	}

	if(isset($season) && strlen($season) === 0){
		$season = \App\App::getDB()->getPDO()->lastInsertId();
	}

	$links = [];
	if(isset($_POST["link"]) && count($_POST["link"]) > 0){
		foreach($_POST["link"] as $link){
			array_push($links, $link);
		}
	}

	if( strlen($season) > 0 && isset($_POST["episode_number"]) && strlen($_POST["episode_number"]) > 0 && count($_POST["link"]) > 0 ){
		\admin\Table\Everything::addEpisode($season, $episode_number, $episode_title, $links);
		echo '<div class="alert alert-success">Episode added successfully.</div>';
	}
}


?>
<h1>Add episode</h1>
<div class="form-group"><h2><span class="label label-default"><?php echo $series->id_series . " - " . $series->name_series ?></span></h2></div>
<div class="row">
	<form action="" method="post">
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label>Choose Season</label>
						<select class="form-control" name="season">
							<option value="">Choose season</option>
							<?php foreach($allSeasons as $s) : ?>
								<option value="<?php echo $s->id_season ?>"><?php echo $s->num_season ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label>Add Season</label>
						<input type="text" class="form-control" name="new_season">
					</div>	
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Episode number</label>
						<input type="text" class="form-control" name="episode_number">
					</div>
				</div>
				<div class="col-md-8">
					<div class="form-group">
						<label>Episode title</label>
						<input type="text" class="form-control" name="episode_title">
					</div>
				</div>
			</div>
			<div class="form-group">
				<label>Link</label>
				<div class="row">
					<div class="col-md-10 links">
						<input type="text" class="form-control" placeholder="http://example.com/..." name="link[]"><br/>
					</div>
					<div class="col-md-2">
						<button class="btn btn-primary add-link"><span class="glyphicon glyphicon-plus" style="margin-right:10px"></span>Add link</button>						
					</div>
				</div>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus" style="margin-right:10px"></span>Add episode</button>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">
	(function($){
		$(".add-link").click(function(e){

			e.preventDefault();
			var html = '<div class="row"><div class="col-md-10">';
			html += '<input type="text" class="form-control" placeholder="http://example.com/..." name="link[]"></div>';
			html += '<div class="col-md-2"><a href="" class="btn btn-danger remove-link"><span class="glyphicon glyphicon-remove"></span></a></div></div><br/>';
			console.log(html);
			$(".links").append(html);

			$(".remove-link").click(function(e){
				e.preventDefault();
				$(this).parent().parent().next("br").remove();
				$(this).parent().parent().remove();
			});

		});
	})(jQuery);
</script>