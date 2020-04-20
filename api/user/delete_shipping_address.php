<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if (!empty($_POST['s_address_id'])) {
 		
 		$s_address_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['s_address_id']));

 		$sql = "DELETE FROM `shipping_address` WHERE `id`='$s_address_id'";
 		if ($res = $connection->query($sql)) {
 			$response =[
				"status" => true,
				'message' => 'Shipping Address Deleted Successfully',
				'code' => 400,
				];
				http_response_code(400);
				echo json_encode($response);
				die();
 		}else{
 			$response =[
				"status" => false,
				'message' => 'Something Went Wrong',
			];
			http_response_code(200);
			echo json_encode($response);
			die();
 		}
 	}else{
 		$response =[
				"status" => false,
				'message' => 'Please Check Required Fields',
		];
		http_response_code(200);
		echo json_encode($response);
		die();
 	}

?>