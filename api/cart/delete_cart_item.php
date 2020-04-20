<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if (!empty($_POST['user_id']) && !empty($_POST['cart_id'])) {

 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
 		$cart_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['cart_id']));

 		$sql = "DELETE FROM `cart` WHERE `id`='$cart_id' AND `u_id`='$user_id'";

 		if ($res = $connection->query($sql)) {
 			
 				$response =[
					"status" => true,
					'message' => 'Item Deleted From The Cart',
					'code' => 200,				
				];
				http_response_code(200);
				echo json_encode($response);
 				die();
 		
 		}else{
 			$response =[
			"status" => false,
			'message' => 'Something Went Wrong',
			'code' => 400,
			];
			http_response_code(400);
			echo json_encode($response);
			die();
 		}

 	}else{
 		$response =[
			"status" => false,
			'message' => 'Required Field Can Not Be Empty',
			'code' => 400,
		];
		http_response_code(400);
		echo json_encode($response);
 	}
 ?>