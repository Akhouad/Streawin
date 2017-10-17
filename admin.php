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
if(!file_exists($admin_paths["views"] . $p . ".php")){
	header("Location: " . getLink("404"));
	die();
}

if (session_status() == PHP_SESSION_NONE) session_start();

if($p != "login"){
	if($_SESSION["auth"] == null || $_SESSION["auth"]->level != "admin"){
		$_SESSION["auth"] = null;
		header("Location: " . getLink("login",[], true));
	}
}

error_reporting(E_ALL);
ini_set("display_errors","On");
require $admin_paths["views"] . "Layout/header.php";

require $admin_paths["views"] . $p . ".php";

require $admin_paths["views"] . "Layout/footer.php";

?>