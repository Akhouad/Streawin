<?php 
$num = 50;
$req = \admin\Table\Everything::showAllSeries($num);
?>
<div class="row">
	<div class="col-md-2">
		<div class="list-group">
			<a href="<?php echo getLink("", [], true); ?>" class="list-group-item active">Series</a>
			<a href="<?php echo getLink("episodes", [], true); ?>" class="list-group-item">Episodes</a>
		</div>
	</div>
	<div class="col-md-10">
		<div class="panel panel-info">
			<div class="panel-heading">Series</div>
			<div class="panel-body">
				<div class="form-group">
					<a href="<?php echo getLink("add-series",[], true) ?>" class="btn btn-success"><span class="glyphicon glyphicon-plus" style="margin-right:10px"></span>Add series</a>
					<a href="<?php echo getLink("add-media",[], true) ?>" class="btn btn-primary"><span class="glyphicon glyphicon-plus" style="margin-right:10px"></span>Add media</a>
					<a href="<?php echo getLink("add-trailer",[], true) ?>" class="btn btn-info"><span class="glyphicon glyphicon-plus" style="margin-right:10px"></span>Add trailer</a>
				</div>




				<div class="row">
					<?php 
					$data = $req->fetchAll();
					$data = array_chunk($data, count($data) /2) ;
					?>
					<?php foreach($data as $dd):?>
						<div class="col-md-6">

							<table class="table">
								<thead class="thead-inverse">
									<tr>
										<th>#</th>
										<th>Series image</th>
										<th>Series name</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
							<?php foreach($dd as $d): ?>
								<tr>
									<td><a href="<?php echo getLink(null, ["title"=>$d->name_series, "id"=>$d->id_series]) ?>" target="_blank"><?php echo $d->id_series; ?></a></td>
									<td>
										<a href="<?php echo getLink(null, ["title"=>$d->name_series, "id"=>$d->id_series]) ?>" target="_blank">
											<img src="<?php echo "$d->image" ?>" alt="" width="100">
										</a>
									</td>
									<td><?php echo $d->name_series; ?></td>
									<td>
										<a href="<?php echo getLink("episodes",["page"=>"series", "id_series"=>$d->id_series], true) ?>" class="btn btn-info" style="margin-bottom:5px">
											<span class="glyphicon glyphicon glyphicon-arrow-right" title="episodes"></span>
										</a>
										<a href="<?php echo getLink("edit-series",["title"=>$d->name_series, "id_series"=>$d->id_series], true) ?>" class="btn btn-primary" style="margin-bottom:5px">
											<span class="glyphicon glyphicon-pencil" title="edit"></span>
										</a><br />
										<a href="<?php echo getLink("add-episode",["title"=>$d->name_series, "id_series"=>$d->id_series], true) ?>" class="btn btn-success" style="margin-bottom:5px">
											<span class="glyphicon glyphicon-plus" title="add"></span>
										</a>
										<a href="<?php echo getLink("delete-series",["title"=>$d->name_series, "id_series"=>$d->id_series], true) ?>" class="btn btn-danger delete-series">
											<span class="glyphicon glyphicon-remove" title="delete"></span>
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
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
			jq(".delete-series").on("click", function(e){
				if(!confirm("confirm delete...")){
					e.preventDefault();
				}
			});
		});
	})(document, window, jQuery);
</script>