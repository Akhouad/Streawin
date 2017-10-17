<?php
require "paths.php";
require $paths["app"] . "Autoloader.php";
require $paths["core"] . "functions.php";

App\Autoloader::register();
App\App::getDB()->getPDO();

$p = "home";
if(isset($_GET["p"])){
	$p = $_GET["p"];
}
if(!file_exists($paths["views"] . $p . ".php")){
	header("Location: " . getLink("404"));
	die();
}

ob_start('removeWhitespace');

error_reporting(E_ALL);
ini_set("display_errors","On");
if(!isset($_GET["r"])) require $paths["views"] . "Layout/header.php";
require $paths["views"] . $p . ".php";
if(!isset($_GET["r"])) require $paths["views"] . "Layout/footer.php";

ob_get_flush();
?>