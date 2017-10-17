<?php
if( empty($_GET) || $_GET["id_series"] === "" ){
	header("Location: " . getLink("", [], true));
	die(); exit();
}
$id_series = $_GET["id_series"];
$series = new \admin\Table\Series($id_series);
$series = $series->getInfo()->fetch();
var_dump($series);
?>

<div class="row">
	<div class="col-md-2">
		<img src="<?php echo $series->image?>" alt="image" style="width:100%">
	</div>
	<div class="col-md-5">
		sdg
	</div>
</div>