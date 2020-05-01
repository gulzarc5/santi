<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if (!empty($_POST['user_id'])) {
		 $user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
		 $page =  $connection->real_escape_string(mysql_entities_fix_string($_POST['page']));

 		$sql_wallet = "SELECT * FROM `wallet` WHERE `user_id`='$user_id'";
 		if ($res = $connection->query($sql_wallet)) {

 			if ($res->num_rows > 0) {
 				$row = $res->fetch_assoc();
				$sql_wallet_history_count = "SELECT * FROM `wallet_history` WHERE `wallet_id`='$row[id]'";
				if ($sql_wallet_history_count = $connection->query($sql_wallet_history_count)) {

					$total_rows = $sql_wallet_history_count->num_rows;
					if ($total_rows > 0) {
						$total_page = ceil($total_rows/10);		
						$limit = ($page*10)-10;
						$sql_wallet_history = "SELECT * FROM `wallet_history` WHERE `wallet_id`='$row[id]' ORDER BY `id` DESC LIMIT $limit,10";
						if ($res_wallet_history = $connection->query($sql_wallet_history)) {
							if ($res_wallet_history->num_rows > 0) {
								while ($row_wallet_history = $res_wallet_history->fetch_assoc()) {
									$history[] = [
										'history_id' => $row_wallet_history['id'],
										'transaction_type' => $row_wallet_history['transaction_type'],
										'transaction_amount' => $row_wallet_history['amount'],
										'total_amount' => $row_wallet_history['total'],
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
							   'inactive_amount' => $row['current_cashback_amount'],
							   'active_amount' => $row['amount'],
							   'total_amount' => $row['total_amount'],
							   'status' => $row['status'],
								'history' => $history,
							];
							$response =[
							   "status" => true,
							   'message' => 'Wallet History',
								'total_page'=> $total_page,
							   'data' => $data,
						   ];
						   http_response_code(200);
						   echo json_encode($response);
						   die();
						}else{
							$data = [];
							$response =[
							   "status" => false,
							   'message' => 'Something Went Wrong Please Try Again',
							   'total_page'=> $total_page,
							   'data' => $data,
						   ];
						   http_response_code(200);
						   echo json_encode($response);
						   die();
						}
					}else{
						$history = [];
						$data = [
							'id' => $row['id'],
							'user_id' => $row['user_id'],
							'inactive_amount' => $row['current_cashback_amount'],
							'active_amount' => $row['amount'],
							'total_amount' => $row['total_amount'],
							'status' => $row['status'],
							'history' => $history,
						 ];
						 $response =[
							"status" => true,
							'message' => 'Wallet History',
							'total_page'=> 1,
							'data' => $data,
						];
						http_response_code(200);
						echo json_encode($response);
						die();
					}
					
				}
 			}else{
 				$data = [];
 				$response =[
					"status" => false,
					'message' => 'Sorry Wallet Not Found',
					'total_page'=> 1,
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
				'message' => 'Something Went Wrong Please Try Again',
				'total_page'=> 1,
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
				'message' => 'Please Check Required Fields',
				'total_page'=> 1,
				'data' => $data,
			];
			http_response_code(200);
			echo json_encode($response);
			die();
 	}

?>