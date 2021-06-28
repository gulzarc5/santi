<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
	 header("content-type: application/json");
	 date_default_timezone_set('Asia/Kolkata');

 	if (!empty($_POST['product_id'])) {
 		$product_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['product_id']));
 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
 		// $price = $connection->real_escape_string(mysql_entities_fix_string($_POST['price']));
 		$quantity = $connection->real_escape_string(mysql_entities_fix_string($_POST['quantity']));
 		$date = date("Y-m-d H:i:s");
 		$sql_check = "SELECT * FROM `cart` WHERE `u_id`='$user_id' AND `p_id`='$product_id'";
 		if ($res_check = $connection->query($sql_check)) {
 			if ($res_check->num_rows == 0) {
				$sql = "INSERT INTO `cart`(`id`, `p_id`, `u_id`, `quantity`, `date`) VALUES (null,'$product_id','$user_id','$quantity','$date')";
				if ($res = $connection->query($sql)) {
					$response =[
				   "status" => true,
				   'message' => 'Item Added In The Cart',
				   ];
				   http_response_code(200);
				   echo json_encode($response);
				}else{
					$response =[
				   "status" => false,
				   'message' => 'Something Went Wrong',
				   ];
				   http_response_code(200);
				   echo json_encode($response);
				}
 			}else{
				$response =[
					"status" => true,
					'message' => 'Item Added In The Cart',
					];
					http_response_code(200);
					echo json_encode($response);
			 }
 		}else{
			$response =[
			   "status" => false,
			   'message' => 'Required Field Can Not Be Empty',
		   ];
		   http_response_code(200);
		   echo json_encode($response);
		}
 	}else{
 		$response =[
			"status" => false,
			'message' => 'Required Field Can Not Be Empty',
		];
		http_response_code(200);
		echo json_encode($response);
 	}
 ?>