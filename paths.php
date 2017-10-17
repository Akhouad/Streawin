<?php
if(!defined("DS")){
	define("DS", DIRECTORY_SEPARATOR);
}


$paths = [];
$paths["base"] = __DIR__ . DS;
$paths["app"] = $paths["base"] . "App" . DS;
$paths["views"] = $paths["app"] . "Views" . DS;
$paths["core"] = $paths["base"] . "Core" . DS;
$paths["public"] = $paths["base"] . "Public" . DS;

$admin_paths = [];
$admin_paths["base"] = $paths["base"] . "admin" . DS;
$admin_paths["views"] = $admin_paths["base"] . "Views" . DS;