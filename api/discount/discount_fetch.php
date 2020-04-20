<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if (!empty($_POST['user_id'])) {
 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
 		$sql = "SELECT * FROM `offer` WHERE `offer_type`='1' LIMIT 1";
 		if ($res = $connection->query($sql)) {
 			$row = $res->fetch_assoc();
 			$response =[
				"status" => true,
				'message' => 'Offer Above 3000',
				'code' => 200,
				'offer' => $row['percentage'],
				];
				http_response_code(200);
				echo json_encode($response);
				die();
 		}else{
 			$response =[
				"status" => false,
				'message' => 'Something Went Wrong',
				'code' => 400,
				'offer' => null,
				];
				http_response_code(400);
				echo json_encode($response);
				die();	
 		}
 	}else{
 			$response =[
				"status" => false,
				'message' => 'Please Check Required Fields',
				'code' => 400,
				'offer' => null,
				];
				http_response_code(400);
				echo json_encode($response);
				die();
 	}
?>