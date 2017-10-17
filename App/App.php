<?php
namespace App;
class App{

	const DB_NAME = "streawin";
	const DB_HOST = "localhost";
	const DB_PASS = "";
	const DB_USER = "root";

	private static $db;

	public static function getDB(){
		if(self::$db === null){
			self::$db = new Database(self::DB_HOST, self::DB_NAME, self::DB_USER, self::DB_PASS);
		} 
		return self::$db;
	}

}