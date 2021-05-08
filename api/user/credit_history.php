<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if (!empty($_POST['user_id'])) {
		 $user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
		 $page =  $connection->real_escape_string(mysql_entities_fix_string($_POST['page']));

 		$sql_credit = "SELECT * FROM `user_credit` WHERE `user_id`='$user_id'";
 		if ($res = $connection->query($sql_credit)) {

 			if ($res->num_rows > 0) {
 				$row = $res->fetch_assoc();
				$sql_credit_history_count = "SELECT * FROM `user_credit_details` WHERE `credit_id`='$row[id]'";
				if ($sql_credit_history_count = $connection->query($sql_credit_history_count)) {

					$total_rows = $sql_credit_history_count->num_rows;
					if ($total_rows > 0) {
						$total_page = ceil($total_rows/10);		
						$limit = ($page*10)-10;
						$sql_credit_history = "SELECT * FROM `user_credit_details` WHERE `credit_id`='$row[id]' ORDER BY `id` DESC LIMIT $limit,10";
						if ($res_credit_history = $connection->query($sql_credit_history)) {
							if ($res_credit_history->num_rows > 0) {
								while ($row_credit_history = $res_credit_history->fetch_assoc()) {
									$history[] = [
										'history_id' => $row_credit_history['id'],
										'transaction_type' => $row_credit_history['type'],
										'transaction_amount' => $row_credit_history['amount'],
										'total_amount' => $row_credit_history['total_amount'],
										'comment' => $row_credit_history['comment'],
										'date' => $row_credit_history['date'],
										
										
									];
								}
							}else{
								$history = [];
							}
								
							$data = [
							   'id' => $row['id'],
							   'total_amount' => $row['amount'],
							  	'history' => $history,
							];
							$response =[
							   "status" => true,
							   'message' => 'Credit History',
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
							'total_amount' => $row['amount'],
							
							'history' => $history,
						 ];
						 $response =[
							"status" => true,
							'message' => 'Credit History',
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
					'message' => 'Sorry Credit Not Found',
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