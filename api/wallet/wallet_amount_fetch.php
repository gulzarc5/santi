<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if (!empty($_POST['user_id'])) {
 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));

 		$sql_wallet = "SELECT * FROM `wallet` WHERE `user_id`='$user_id'";
 		if ($res = $connection->query($sql_wallet)) {

 			if ($res->num_rows > 0) {
 				$row = $res->fetch_assoc();

	 			$data = [
	 				'id' => $row['id'],
	 				'user_id' => $row['user_id'],
	 				'inactive_amount' => $row['current_cashback_amount'],
	 				'active_amount' => $row['amount'],
	 				'total_amount' => $row['total_amount'],
	 				'status' => $row['status'],
	 			];
	 			$response =[
					"status" => true,
					'message' => 'Wallet Balance',
					'data' => $data,
					];
					http_response_code(200);
					echo json_encode($response);
					die();
 			}else{
 				$response =[
					"status" => false,
					'message' => 'No Wallet Found',
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