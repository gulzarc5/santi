<?php

	include_once '../../php/database/connection.php';
	header("content-type: application/json");

	if (!empty($_POST['api_key']) && !empty($_POST['user_id'])) {
		$api_key = $connection->real_escape_string(mysql_entities_fix_string($_POST['api_key']));
		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));

		$sql = "SELECT * FROM `api_key` WHERE `user_id`='$user_id' AND `api_key`='$api_key'";

		if ($res_key = $connection->query($sql)) {
			if ($res_key->num_rows > 0) {
				// $response =[
				// 	"status" => true,
				// 	'message' => 'Api Key Ok',
				// 	'code' => 200,
				// ];
				// http_response_code(200);
				// echo json_encode($response,JSON_NUMERIC_CHECK);
			}else{
				$response =[
					"status" => false,
					'message' => 'Api Key Not Found',
				];
				http_response_code(200);
				echo json_encode($response,JSON_NUMERIC_CHECK);
				die();
			}
		}else{
			$response =[
					"status" => false,
					'message' => 'Api Key Not Found',
				];
			http_response_code(200);
			echo json_encode($response,JSON_NUMERIC_CHECK);
			die();
		}
	}else{
		$response =[
					"status" => false,
					'message' => 'Api Key And User Id Can Not Be Empty',
					'data' =>null,
				];
		http_response_code(200);
		echo json_encode($response,JSON_NUMERIC_CHECK);
		die();
	}


function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
	if (get_magic_quotes_gpc()) 
	    $string = stripslashes($string);
	    return $string;
}	
?>