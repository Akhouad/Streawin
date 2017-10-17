<?php
$id_episode = $_POST["id_episode"];
// $id_episode = $_GET["id_episode"];
\App\Table\Everything::addView($id_episode);
?>