<?php 
if(!defined("ROOT")) define("ROOT", $_SERVER['HTTP_HOST'] . DS);
if(!defined("SCRIPT_NAME")) define("SCRIPT_NAME", "streawin" . DS);


/**
 * @param $path string - example : "/streawin/public/css/style.css"
 * @return string - example : http://localhost\streawin\public\css\style.css
*/
function getFileURL($path){
	return  "http://" . ROOT . $path;
}


/**
 * @param $filename string - example : "home"
 * @param $params array - example : ["id"=>2,"season"=>1,"episode"=>5]
 * @return string - example : index.php?p=home&id=2&season=1&episode=5 - OR index.php?p=home if $params is empty
*/
function getLink($filename, $params = array(), $test = false){
	$first = "http://". ROOT;
	// $first .= (!$test) ? "index" : "admin";
	// return (empty($params)) ? $first . ".php?p=".$filename : $first. ".php?p=". $filename ."&" . http_build_query($params, '', '&amp;');

	$first .= (!$test) ? "" : "admin" . DS;
	$first .= (strlen($filename) === 0) ? "" : $filename . DS ;
	if(count($params) > 0){
		foreach($params as $key => $value){
			$value = preg_replace("/[.']/", "", $value);
			$first .= strtolower(str_replace(" ", "-", $value)) . "-";
		}		
	}

	return rtrim($first, "-");
}


function removeWhitespace($buffer)
{
	$buffer = preg_replace('/<!--(.|\s)*?-->/', '', $buffer);
    return preg_replace('/\t+/', '', $buffer);
}