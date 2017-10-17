<?php 
$id_series = $_GET["id_series"];
?>
<div class="row">
	<div class="col-md-2">
		<div class="list-group">
			<a href="<?php echo getLink("", [], true); ?>" class="list-group-item">Series</a>
			<a href="<?php echo getLink("episodes", [], true); ?>" class="list-group-item active">Episodes</a>
		</div>
	</div>
	<div class="col-md-10">
		<div class="panel panel-info">
			<div class="panel-heading">Episodes</div>
			<div class="panel-body">
				<div class="form-group">
					<a href="<?php echo getLink("add-series",[], true) ?>" class="btn btn-success"><span class="glyphicon glyphicon-plus" style="margin-right:10px"></span>Add episode</a>
				</div>




				<div class="row">
					<?php 
					$req = admin\Table\Everything::episodesBySeries($id_series);
					$data = $req->fetchAll();
					// $data = array_chunk($data, ceil(count($data) /2));
					$seasons = admin\Table\Everything::getSeasons($id_series);
					$seasons = $seasons->fetchAll();
					?>
					<?php foreach($seasons as $s): ?>
						<div class="col-md-6">

							<table class="table">
								<thead class="thead-inverse">
									<tr>
										<th>#</th>
										<th>image</th>
										<th>Num / Title</th>
										<th>Series</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
						<?php foreach($data as $d): ?>
							<?php if($d->num_season == $s->num_season) : ?>
								<tr>
									<td><a href="<?php echo getLink("watch",["title"=>$d->name_series, "id_series"=>$d->id_series, "season"=>$d->num_season, "episode"=>$d->num_episode]) ?>" target="_blank"><?php echo $d->id_episode; ?></a></td>
									<td>
										<a href="<?php echo getLink("watch",["title"=>$d->name_series, "id_series"=>$d->id_series, "season"=>$d->num_season, "episode"=>$d->num_episode]) ?>" target="_blank" style="display:inline-block;height:75px;width:75px; overflow:hidden">
											<img src="<?php echo $d->episode_image !== "none" ? $d->episode_image : $d->image ?>" alt="" style="width:100%">
										</a>
									</td>
									<td><?php echo "S".$d->num_season . " E". $d->num_episode . " - " . $d->title_episode; ?></td>
									<td><a href="<?php echo getLink(null, ["title"=>$d->name_series, "id"=>$d->id_series]) ?>" target="_blank"><?php echo $d->name_series ?></a></td>
									<td>
										<a href="<?php echo getLink("edit-episode",["id_episode"=>$d->id_episode], true) ?>" class="btn btn-primary" style="margin-bottom:5px">
											<span class="glyphicon glyphicon-pencil" title="edit"></span>
										</a><br />
										<a href="<?php echo getLink("delete-episode",["id_episode"=>$d->id_episode, "id_series"=>$d->id_series], true) ?>" class="btn btn-danger delete-episode">
											<span class="glyphicon glyphicon-remove" title="delete"></span>
										</a>
									</td>
								</tr>
							<?php endif; ?>
						<?php endforeach ;?>
								</tbody>
							</table>
						</div>
					<?php endforeach; ?>
				</div>





			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	(function(d, w, jq){
		jq(d).ready(function(){
			jq(".delete-episode").on("click", function(e){
				if(!confirm("Confirm delete...")){
					e.preventDefault();
				}
			});
		});
	})(document, window, jQuery);
</script>