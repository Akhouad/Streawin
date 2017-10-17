<?php
if(! isset($_GET) || strlen($_GET["id_episode"]) === 0){
	header("Location: " . getLink("home",[],true));
	die();
}
$id_episode = $_GET["id_episode"];

$req = \App\App::getDB()->query("SELECT * FROM episodes WHERE id_episode = ?",[$id_episode]);
$data = $req->fetch();
if( !$data ){
	header("Location: " . getLink("home",[],true));	
	die();
}

$episode = new admin\Table\Episode($id_episode);

if(isset($_POST["num_episode"]) && $_POST["num_episode"] !== null
	&& isset($_POST["image"]) && $_POST["image"] !== null
	&& isset($_POST["title"]) && $_POST["title"] !== null
	&& isset($_POST["num_season"]) && $_POST["num_season"] !== null
	&& isset($_POST["synopsis"]) && $_POST["synopsis"] !== null)
{
	$num_episode = $_POST["num_episode"];
	$image = $_POST["image"];
	$title = $_POST["title"];
	$num_season = $_POST["num_season"];
	$synopsis = $_POST["synopsis"];
	
	$episode->editEpisode($num_episode, $image, $title, $num_season, $synopsis);
	echo '<div class="alert alert-success">Episode edited successfully.</div>';
}

$ep_info = $episode->getInfo()->fetch();


if(isset($_POST["servers"]) && $_POST["servers"] !== null && count($_POST["servers"]) !== 0){
	$episode->insertLinks($_POST["servers"]);
	echo '<div class="alert alert-success">Links inserted successfully.</div>';
}



$series = new \admin\Table\Series($episode->getSeriesId());
$series = $series->getInfo()->fetch();

$links = $episode->getLinks()->fetchAll();
$next = \admin\Table\Everything::nextEpisode($ep_info->id_episode);
$prev = \admin\Table\Everything::prevEpisode($ep_info->id_episode);
?>
<div class="row">
	<div class="col-md-2">
		<div class="list-group">
			<a href="<?php echo getLink("", [], true); ?>" class="list-group-item">Series</a>
			<a href="<?php echo getLink("episodes",["page"=>"series", "id_series"=>$series->id_series], true) ?>" class="list-group-item active">Episodes</a>
		</div>
	</div>
	<div class="col-md-10">

		<a href="<?= getLink("edit-series",["title"=>$series->name_series, "id_series"=>$series->id_series], true)?>"   class="btn btn-success" 
		   style="margin-bottom:5px">
			<span class="glyphicon glyphicon-pencil" title="edit" style="margin-right:10px"></span>Edit series
		</a>

		<a href="<?= getLink("watch",["title"=>$series->name_series, "id_series"=>$series->id_series, "season"=>$ep_info->num_season, "episode"=>$ep_info->num_episode]) ?>" 
		   class="btn btn-info" 
		   target="_blank" 
		   style="margin-bottom:5px">Episode
		</a>

		<div style="float:right">
			<?php if($prev) : ?>
			<a href="<?= getLink("edit-episode",["id_episode"=>$prev->id_episode], true) ?>" 
		  		class="btn btn-info" 
		   		style="margin-bottom:5px"><
			</a>
			<?php endif;?>
			<?php if($next) : ?>
			<a href="<?= getLink("edit-episode",["id_episode"=>$next->id_episode], true) ?>" 
		  		class="btn btn-info" 
		   		style="margin-bottom:5px">>
			</a>
			<?php endif;?>
		</div>

		<div class="panel panel-info">
			<div class="panel-heading"><?php echo $series->name_series ?></div>
			<div class="panel-body">
				<form action="#" method="post">
					<div class="row">
						<div class="col-md-1">
							<div class="form-group">
								<label>episode</label>
								<input type="text" class="form-control" value="<?php echo $ep_info->num_episode ?>" name="num_episode">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label>image</label>
								<input type="text" class="form-control" value="<?php echo $ep_info->episode_image ?>" name="image">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>title</label>
								<input type="text" class="form-control" value="<?php echo $ep_info->title_episode ?>" name="title">
							</div>
						</div>
						<div class="col-md-2">
							<div class="form-group">
								<label>season</label>
								<input type="text" class="form-control" value="<?php echo $ep_info->num_season ?>" name="num_season">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label>image</label>
								<img src="<?php echo $ep_info->episode_image ?>" alt="image" class="img-thumbnail">
							</div>
						</div>
						<div class="col-md-9">
							<div class="form-group">
								<label>synopsis</label>
								<textarea class="form-control" rows="6" name="synopsis">
									<?php echo trim($ep_info->synopsis) ?>
								</textarea>
							</div>
						</div>
					</div>
					<button class="btn btn-success">Save Episode</button>
				</form>
			</div>
		</div>

		<div class="panel panel-success">
			<div class="panel-heading">Servers</div>
			<div class="panel-body">
				<form method="post" action="#">
					<div class="form-group">
						<button class="btn btn-success add-server">Add Server</button>
						<button type="submit" class="btn btn-primary save-servers" disabled="disabled">Save Servers</button>
					</div>
					<?php foreach($links as $l): ?>
					<div class="form-group serv">
						<label style="float:left;width:100%">Server</label>
						<input 
							type="text" 
							class="form-control"
							name="servers[]" 
							value="<?= $l->link ?>"
							style="width:75%;float:left;margin-right:10px"
							/>
						<a href="" class="remove-server btn btn-danger">x</a>
					</div>
					<?php endforeach;?>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	(function(d,w,jq){
		function enable(){
			(jq(".serv").length > 0) ? jq(".save-servers").removeAttr("disabled") : jq(".save-servers").attr("disabled", "disabled");
		};
		enable();

		jq(".add-server").on("click", function(e){
			e.preventDefault();
			var html = '<div class="form-group serv"><label style="float:left;width:100%">Server</label><input type="text" class="form-control"name="servers[]" style="width:75%;float:left;margin-right:10px"/><a href="" class="remove-server btn btn-danger">x</a></div>';
			jq(this).parents(".panel-body").find("form").append(html);

			// alert(jq("[name='servers[]']").length);

			jq(this).parents(".serv").find(".remove-server").on("click", function(e){
				e.preventDefault();
				alert("dgfg");
				if(confirm("confirm")) jq(this).parent(".serv").remove();
				console.log("called.");
				enable();
				return false;
			});
			enable();
		});

			jq(".serv").find(".remove-server").on("click", function(e){
				e.preventDefault();
				if(confirm("confirm")) jq(this).parent(".serv").remove();
				console.log("called.");
				enable();
				return false;
			});
	})(document,window,jQuery);
</script>