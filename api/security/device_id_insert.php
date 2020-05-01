<?php
	include '../../php/database/connection.php';
	header("content-type: application/json");
	date_default_timezone_set('Asia/Kolkata');

	if (!empty($_GET['device_id'])) {
		$device_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['device_id']));
		$sql = "SELECT * FROM `app_device` WHERE `device_id`='$device_id'";
		$date = date("Y-m-d H:i:s");
		if ($res = $connection->query($sql)) {
			if ($res->num_rows == 0) {
				$sql_insert = "INSERT INTO `app_device`(`id`, `device_id`, `user_id`, `date`) VALUES (null,'$device_id',null,'$date')";
				if ($res = $connection->query($sql_insert)){
					$response =[
						"status" => true,
						'message' => 'Your Device Setup Successfully',
						'code' => 200,
					];
					http_response_code(200);
					echo json_encode($response);
				}
			}else{
				$response =[
						"status" => false,
						'message' => 'Your Device already exist',
						'code' => 400,
					];
					http_response_code(400);
					echo json_encode($response);
			}
		}
		

	}else{
		$response =[
			"status" => false,
			'message' => 'Something Wrong With Your Device',
			'code' => 404,
		];
		http_response_code(400);
		echo json_encode($response);
	}
	


	function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
	function mysql_fix_string($string){
	    if (get_magic_quotes_gpc()) 
	        $string = stripslashes($string);
	    return $string;
	}
?>