<?php
namespace App;

class Autoloader{
	public static function register(){
		spl_autoload_register(array(__CLASS__, "autoload"));
	}

	public static function autoload($class_name){
		$nameSpace = explode('\\', $class_name);
		$link = "";
		foreach($nameSpace as $key => $value){
			$link .= $value . DS;
		}
		$link = rtrim($link, DS);
		require $link . ".php";
	}
}