<?php
if(empty($_GET["id_series"]) || empty($_GET["season"]) || empty($_GET["episode"]) ){
	header("Location: " . getLink("404"));
	die();
}
$id_series = $_GET["id_series"];
$num_season = $_GET["season"];
$num_episode = $_GET["episode"];
$data = \App\Table\Everything::seriesById($id_series)->fetch();
$cover = (new \App\Table\Series($id_series))->getCover()->fetch();

$current_episode = \App\Table\Everything::currentEpisode($id_series, $num_season, $num_episode)->fetch();
$next_episode = \App\Table\Everything::nextEpisode($id_series, $num_season, $num_episode)->fetch();
$prev_episode = \App\Table\Everything::prevEpisode($id_series, $num_season, $num_episode)->fetch();

$links = \App\Table\Everything::getLinks($current_episode->id_episode)->fetchAll();

$e = ($current_episode->num_episode < 10) ? "0".$current_episode->num_episode : $current_episode->num_episode;
$s = ($current_episode->num_season < 10) ? "0".$current_episode->num_season : $current_episode->num_season;


$keywords = [
	$data->name_series,
	"episode",
	"series",
	"season",
	"episode " . $current_episode->num_episode,
	"season " . $current_episode->num_season,
	$data->genres,
	$current_episode->title_episode
];
site_head("S".$s." E".$e." - ".$data->name_series, $keywords);
?>
<div class="right" style="margin-top:60px">
	<span style="display:none" class="ep"><?php echo $current_episode->id_episode ?></span>
	<div class="site_map">
		<div style="float:left">
			<a href="<?php echo getLink("",["title"=>$data->name_series, "id"=>$data->id_series]) ?>"><?php echo $data->name_series ?></a>
			<?php echo " <i class='icon ion-arrow-right-b' style='margin:0 7px'></i> Season " . (($num_season < 10) ? "0" . $num_season : $num_season) . " <i class='icon ion-arrow-right-b' style='margin:0 7px'></i> Episode " . (($num_episode < 10) ? "0" . $num_episode : $num_episode) ?>
		</div>
		<div style="float:right">
			<a class="btn danger report" style="margin-top:5px" href=""><span><i class="icon ion-close-round"></i> report</span></a>
		</div>
	</div>


	<div class="servers">
		<?php 
			$src = $data->image;
			if($current_episode->original_image != "none") $src = $current_episode->original_image;
			else if($cover != false ) $src = $cover->original_image;
		?>
		<img src="<?= $src ?>" alt="image">

		<div class="play_title">
			<i class="icon ion-ios-play"></i>
			<div class="title"><?php echo $current_episode->title_episode ?></div>
		</div>
		<div class="frame">
			<ul class="servers">
			<?php for($i=0; $i < count($links) ;$i++): ?>
				<li><a href="" class="server_link <?php echo($i === 0) ? "active" : "" ?>" data-link="<?= $links[$i]->link ?>">
					Server <?= $i+1 ?>
				</a></li>
			<?php endfor;?>
			</ul>
			<iframe src="<?php echo (isset($links[0]->link) && strlen($links[0]->link) > 0 ) ? $links[0]->link : "" ?>" allowfullscreen="true" FRAMEBORDER=0 MARGINWIDTH=0 MARGINHEIGHT=0 SCROLLING=NO width="640" height="360"></iframe>
			<?php 
			if( isset($links[0]->link) && strlen($links[0]->link) > 0 ){}else{
				echo "Link not found. Please report this page to fix the problem as soon as possible.";
			}
			?>
				

		</div>
	</div>


	<div class="prev_next">
		<a href="<?php echo ($prev_episode) ? getLink("watch",["title"=>$data->name_series, "id_series"=>$id_series, "season"=>$num_season, "episode"=>$prev_episode->num_episode]) : "" ?>" class="prev" style="<?php echo (!$prev_episode) ? "opacity:0" : "" ?>">
			<?php if($prev_episode !== false) : ?>
			<i class="icon ion-ios-arrow-left"></i>
			<div style="float:left">
				<span class="t">previous episode</span>
				<span class="num_episode">Episode <?php echo ($prev_episode->num_episode < 10) ? "0".$prev_episode->num_episode : $prev_episode->num_episode ?></span>
				<span class="title"><?php echo $prev_episode->title_episode ?></span>
			</div>
			<?php endif; ?>
		</a>
		<a href="<?php echo ($next_episode) ? getLink("watch",["title"=>$data->name_series, "id_series"=>$id_series, "season"=>$num_season, "episode"=>$next_episode->num_episode]) : "" ?>" class="next" style="<?php echo (!$next_episode) ? "opacity:0" : "" ?>">
			<?php if($next_episode !== false) : ?>
			<i class="icon ion-ios-arrow-right"></i>
			<div>
				<span class="t">next episode</span>
				<span class="num_episode">Episode <?php echo ($next_episode->num_episode < 10) ? "0".$next_episode->num_episode : $next_episode->num_episode ?></span>
				<span class="title"><?php echo $next_episode->title_episode ?></span>
			</div>
			<?php endif; ?>
		</a>
	</div>

	<div class="left_side">
		<div class="row"><div class="title_1">synopsis</div></div>
		<p style="margin-bottom:30px"><?php echo ($current_episode->synopsis) ? $current_episode->synopsis : $data->synopsis  ?></p>
	</div>
	<div class="right_side">
		<div class="row"><div class="title_1">you may like</div></div>
		<?php require $paths["views"] . "random-series.php" ?>
	</div>
</div>

<div class="popup report_container">
	<div class="content">
		<div class="close_popup">Close [x]</div>
		<form action="#" method="post">
			<div class="input_2" style="margin-bottom:20px">
				<input type="text" name="name" class="name" placeholder="your name">
				<i class="icon ion-android-person"></i> 
			</div>
			<textarea class="textarea_2 message" name="message" style="margin-bottom:20px" placeholder="write a message..."></textarea>
			<button class="btn danger send_report" type="submit">
				<span><i class="icon ion-arrow-right-c"></i> send report</span>
			</button>
		</form>
	</div>
</div>

<script type="text/javascript">
	(function(d,w,jq){
		jq(d).ready(function(){
			// click on report button
			jq(".report").on("click", function(e){
				e.preventDefault();
				jq(".report_container").fadeIn(200);
				jq(".report_container .close_popup").on("click", function(e){
					e.preventDefault();
					jq(this).parents(".report_container").fadeOut(200);
				});
			});

			jq(".send_report").on("click", function(e){
				e.preventDefault();

				jq.ajax({
					type : "post",
					url : "/index.php?p=send-report&r",
					data : {
						"id_episode" : jq(".ep").html(),
						"name" : jq(".name").val(),
						"message" : jq(".message").val()
					},
					success : function(){
						var h = $('<p class="montserrat-text" style="color:#f55353">Report sent, thank you.</p>')
						jq(".report_container").find(".content").children("form").remove();
						jq(".report_container").find(".content").append(h);
					}
				});
			});


			// click on play button
			jq(".play_title").on("click", function(){
				jq(this).parent().children(".frame").fadeIn(200);
				jq(this).hide();
				jq(this).parent().children("img").hide();


				jq(".server_link").on("click", function(e){
					e.preventDefault();
					jq(".server_link").removeClass("active");
					jq(this).addClass("active");
					jq(this).parents(".servers").next("iframe").attr("src", jq(this).data("link"));
				});

				jq.ajax({
					type : "post",
					url : "/index.php?p=add-view",
					data : {
						"id_episode" : jq(".ep").html()
					}
				});
			});
		});
	})(document, window, jQuery);
</script>
<!-- <script type="text/javascript" src="//go.oclasrv.com/apu.php?zoneid=643000"></script> -->