<?php
if(! isset($_GET) || strlen($_GET["id"]) === 0){
	header("Location: " . getLink("home",[],true));
}else{
	$req = \App\App::getDB()->query("SELECT id_series FROM series WHERE id_series = ?",[$_GET["id"]]);
	$data = $req->fetch();
	if( !$data ){
		header("Location: " . getLink("home",[],true));	
	}
}

$id_series = $_GET["id_series"];
\App\App::getDB()->query("DELETE FROM series WHERE id_series = ?",[$id_series]);
echo '<div class="alert alert-success">Series deleted successfully.</div>';
header('Location: ' . getLink("home",[],true));
?>