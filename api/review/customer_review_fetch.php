<?php
	include_once '../../php/database/connection.php';

 	header("content-type: application/json");

 		$sql = "SELECT `users`.`name` AS u_name,`customer_review`.`star` AS star,`customer_review`.`comments` AS comment,`customer_review`.`create_at` AS created_at FROM `customer_review` INNER JOIN `users` ON `users`.`id`=`customer_review`.`user_id` ORDER BY `customer_review`.`id` DESC LIMIT 20";
 		if ($res = $connection->query($sql)) {
 			if ($res->num_rows > 0) {
 				while ($row = $res->fetch_assoc()) {
	 				$data [] = [
	 					'customer_name' => $row['u_name'],
	 					'star' => $row['star'],
	 					'comment' => $row['comment'],
	 					'created_at' => $row['created_at'],
	 				];
	 			}
	 			$response =[
					"status" => true,
					'message' => 'review List',
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
					'message' => 'No Review Found',
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
				'message' => 'Something Went Wrong Please Try Again',
				'code' => 400,
				'data' => $data,
				];
				http_response_code(400);
				echo json_encode($response);
				die();
 		}

?>