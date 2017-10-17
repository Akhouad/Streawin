<?php
if( isset($_POST) && isset($_POST["imdb_id"]) && strlen($_POST["imdb_id"]) > 0 ){

	$imdb_id = (isset($_POST["imdb_id"]) && strlen($_POST["imdb_id"]) > 0 ) ? $_POST["imdb_id"] : false;
	$name = (isset($_POST["name"]) && strlen($_POST["name"]) > 0 ) ? $_POST["name"] : false;
	$genres = (isset($_POST["genres"]) && count($_POST["genres"]) > 0 ) ? $_POST["genres"] : false;
	$release_date = (isset($_POST["release_date"]) && count($_POST["release_date"]) > 0 ) ? $_POST["release_date"] : false;
	$synopsis = (isset($_POST["synopsis"]) && count($_POST["synopsis"]) > 0 ) ? $_POST["synopsis"] : false;
	$runtime = (isset($_POST["runtime"]) && count($_POST["runtime"]) > 0 ) ? $_POST["runtime"] : false;
	$rate = (isset($_POST["rate"]) && count($_POST["rate"]) > 0 ) ? $_POST["rate"] : false;
	$image = (isset($_POST["image"]) && count($_POST["image"]) > 0 ) ? $_POST["image"] : false;
	$trailer = (isset($_POST["trailer"]) && count($_POST["trailer"]) > 0 ) ? $_POST["trailer"] : false;

	if( strlen($imdb_id) > 0 && strlen($name) > 0 ){
		$series = new \admin\Table\NewSeries($imdb_id, $name, $genres, $release_date, $synopsis, $runtime, $rate, $image);
		$series->addSeries();
	}
	if(strlen($trailer) > 0){
		\admin\Table\Everything::addTrailer($trailer, $imdb_id);
	}
}
?>
<h2>Add series</h2>
<div class="row">
	<div class="col-md-8">
		<form action="" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label style="float:left;width:100%">imdb id</label>
				<input type="text" class="form-control imdb" placeholder="imdb_id" name="imdb_id" style="width:80%;float:left;margin-right:10px">
				<a href="" class="btn btn-primary search"><span class="glyphicon glyphicon-search" style="margin-right:10px"></span><span>Search</span></a>
			</div>
			<div class="form-group"><div class="alert alert-success hidden"></div></div>
			<!-- <div class="form-group">
				<label>Select Cover</label>
				<input id="input-1" type="file" class="file" name="cover">
			</div> -->

			<div class="form-group">
				<label>Trailer</label>
				<input class="form-control" type="text" name="trailer">
			</div>

			<input type="text" class="name hidden" name="name">
			<input type="text" class="genres hidden" name="genres">
			<input type="text" class="release_date hidden" name="release_date">
			<input type="text" class="rate hidden" name="rate">
			<input type="text" class="runtime hidden" name="runtime">
			<textarea type="text" class="synopsis hidden" name="synopsis"></textarea>
			<input type="text" class="image hidden" name="image">

			<div class="form-group">
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus" style="margin-right:10px"></span>Add Series</button>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$(window).load(function(){
		$(".search").on("click", function(e){
			e.preventDefault();
			if($(".imdb").val() !== ""){

				var self = $(this);
				self.removeClass("btn-primary").addClass("btn-danger");
				self.find("span").first().removeClass("glyphicon-search").addClass("glyphicon-refresh");
				self.find("span").eq(1).html("Load ...");
				var id_;

				$.ajax({

					dataType: "json",
					url: "http://api.tvmaze.com/lookup/shows?imdb=" + $(".imdb").val().trim(),
					success: function(data){
						console.log(data);
						id_ = data.id;
						$(".name").val(data.name);
						$(".genres").val(data.genres);
						$(".image").val(data.image.medium);
						$(".release_date").val(data.premiered);
						$(".rate").val(data.rating.average);
						$(".runtime").val(data.runtime);
						$(".synopsis").html(data.summary.replace("<p>", '').replace("</p>", ""));

					},

				}).fail(function(){

					self.addClass("btn-danger");
					self.find("span").first().addClass("glyphicon-remove").removeClass("glyphicon-refresh");
					self.find("span").eq(1).html("Not found");

				}).done(function(){

					self.addClass("btn-success").removeClass("btn-danger");
					self.find("span").first().addClass("glyphicon-check").removeClass("glyphicon-refresh");
					self.find("span").eq(1).html("Found");

					$.ajax({

						dataType: "json",
						url: "http://api.tvmaze.com/shows/"+ id_ +"/episodes",
						success: function(data){

							for(var i = 0 ; i < data.length ; i++){

								$.ajax({
									type : "post",
									url : "../add-episodes",
									data : {
										"imdb_id" : $(".imdb").val(),
										"name" : data[i].name,
										"number" : data[i].number,
										"season" : data[i].season,
										"image" : (data[i].image && typeof data[i].image.medium !== "undefined" ) ? data[i].image.medium : "none" ,
										"original_image" : (data[i].image && typeof data[i].image.original !== "undefined" ) ? data[i].image.original : "none" ,
										"synopsis" : data[i].summary.replace("<p>", '').replace("</p>", ""),
										"date" : data[i].airdate,
									}
								})

							}
							$(".alert").removeClass("hidden").html("Episodes added successfully.");

						},

					}).done(function(){

						var j = 0;
						$.ajax({

							dataType: "json",
							url: "http://api.tvmaze.com/shows/" + id_ + "?embed=cast",
							success: function(data_){

								for(var i = 0 ; i < data_._embedded.cast.length ; i++){
									var person = data_._embedded.cast[i].person.name;
									var character = data_._embedded.cast[i].character.name;
									var image = data_._embedded.cast[i].person.image;
									var imdb_id = data_.externals.imdb;

									$.ajax({
										type : "post",
										url : "../add-cast",
										data : {
											"person" : person,
											"character" : character,
											"original_image" : image.original,
											"image" : image.medium,
											"imdb_id" : imdb_id
										}
									}).done(function(data){console.log(data);j++;});

								}

								if(j === data_._embedded.cast.length - 1)
									$(".alert").removeClass("hidden").html("Cast added successfully.");

							},

						});

					});

				});

			}
		});
	});
</script>