<?php 
if( !isset($_POST) || count($_POST) === 0 ) { header("Location : " . getLink("",[],true)); exit();die(); }
$imdb_id = $_POST["imdb_id"];
$name = $_POST["name"];
$number = $_POST["number"];
$season = $_POST["season"];
$image = $_POST["image"];
$original_image = $_POST["original_image"];
$synopsis = $_POST["synopsis"];
$date = $_POST["date"];
\admin\Table\Everything::addEpisode($imdb_id, $number, $name, $season, $image, $original_image, $synopsis, $date);
echo "episodes added successfully.";
?>