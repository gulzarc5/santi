<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if (!empty($_POST['user_id'])) {
 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));

 		$sql_wallet = "SELECT `users`.`is_star` as is_star, `wallet`.`status` AS wallet_status, `wallet`.`amount` AS amount FROM `users` INNER JOIN `wallet` ON `wallet`.`user_id`=`users`.`id` WHERE `users`.`id`='$user_id'";
 		if ($res = $connection->query($sql_wallet)) {

 			if ($res->num_rows > 0) {
 				$row = $res->fetch_assoc();

	 			$data = [
	 				'is_star' => $row['is_star'],
	 				'wallet_status' => $row['wallet_status'],
	 				'wallet_amount' => $row['amount'],
	 			];
	 			$response =[
					"status" => true,
					'message' => 'Star Check Data',
					'data' => $data,
					];
					http_response_code(200);
					echo json_encode($response);
					die();
 			}else{
 				$response =[
					"status" => false,
					'message' => 'No Data Found',
					'data' => null,
				];
				http_response_code(200);
				echo json_encode($response);
				die();
 			}
 			
 		}else{
 			$response =[
				"status" => false,
				'message' => 'Something Went Wrong',
				'data' => null,
			];
			http_response_code(200);
			echo json_encode($response);
			die();
 		}
 	}else{
 		$response =[
			"status" => false,
			'message' => 'Please Check Required Fields',
			'data' => null,
		];
		http_response_code(200);
		echo json_encode($response);
		die();
 	}

?>