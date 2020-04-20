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

 				$sql_wallet_history = "SELECT * FROM `wallet_history` WHERE `wallet_id`='$row[id]' ORDER BY `id` DESC";
 				if ($res_wallet_history = $connection->query($sql_wallet_history)) {
 					if ($res_wallet_history->num_rows > 0) {
 						while ($row_wallet_history = $res_wallet_history->fetch_assoc()) {
	 						$history[] = [
	 							'transaction_type' => $row_wallet_history['transaction_type'],
	 							'transaction_amount' => $row_wallet_history['amount'],
	 							'wallet_amount' => $row_wallet_history['total'],
	 							'comment' => $row_wallet_history['comments'],
	 							'date' => $row_wallet_history['date'],
	 							'time' => $row_wallet_history['time'],
	 							
	 						];
	 					}
 					}else{
 						$history = [];
 					}
	 					
 					$data = [
		 				'id' => $row['id'],
		 				'user_id' => $row['user_id'],
		 				'amount' => number_format($row['amount'],2,'.', ''),
		 				'status' => $row['status'],
		 				'history' => $history,
		 			];
		 			$response =[
						"status" => true,
						'message' => 'Wallet Balance',
						'code' => 200,
						'data' => $data,
						];
						http_response_code(200);
						echo json_encode($response);
						die();
 				}else{
 					$data = [];
	 				$response =[
						"status" => true,
						'message' => 'Customer Wallet Is Not Created',
						'code' => 200,
						'data' => $data,
						];
						http_response_code(200);
						echo json_encode($response);
						die();
 				}
 			}else{
 				$data = [];
 				$response =[
					"status" => true,
					'message' => 'Customer Wallet Is Not Created',
					'code' => 200,
					'data' => $data,
					];
					http_response_code(200);
					echo json_encode($response);
					die();
 			}
 			
 		}else{
 			$data = [];
 			$response =[
				"status" => false,
				'message' => 'Something Went Wrong',
				'code' => 400,
				'data' => $data,
				];
				http_response_code(400);
				echo json_encode($response);
				die();
 		}
 	}else{
 		$data = [];
 		$response =[
				"status" => false,
				'message' => 'Please Check Required Fields',
				'code' => 400,
				'data' => $data,
				];
				http_response_code(400);
				echo json_encode($response);
				die();
 	}

?>