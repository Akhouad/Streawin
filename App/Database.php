<?php
namespace App;
use \PDO;

class Database{

	private $host;
	private $dbname;
	private $root;
	private $pass;

	private $pdo = null;

	public function __construct($host = "localhost", $dbname="streawin", $root="root", $pass=""){
		$this->host = $host;
		$this->dbname = $dbname;
		$this->root = $root;
		$this->pass = $pass;
	}

	public function getPDO(){
		if($this->pdo === null){
			try{
				$this->pdo = new PDO("mysql:dbname=" . $this->dbname . ";host=" . $this->host, $this->root, $this->pass);
				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			}catch(PDOException $e){
				die(" Query failed : " . $e->getMessage());
			}
		}
		return $this->pdo;
	}

	/**
	  * @param $statment string
	  * @param $params array : parameters of statment
	  * example : query("select * from series where id_series = ? and title_series = ?",[1, "the100"]);
	**/
	public function query($statment, $params = array(), $test = false){
		if($test){
			$req = $this->pdo->prepare("$statment");
			$req->execute($params);
			return $req;
		}
		if(!empty($params)){
			$req = $this->pdo->prepare($statment);

			foreach($params as $key => $value){
				$value = htmlentities(htmlspecialchars($value));
				$params[$key] = $value;
			}

			$req->execute($params);
		}else{
			$req = $this->pdo->query($statment);
		}

		return $req;
	}

}
?>