<?php
if(empty($_POST["name"]) && empty($_POST["message"]) && empty($_POST["id_episode"]) ) die();

$name = $_POST["name"];
$message = $_POST["message"];
$id_episode = $_POST["id_episode"];

$report = new \App\Table\Report($name, $message, $id_episode);
// var_dump($report);
$report->sendReport();
?>