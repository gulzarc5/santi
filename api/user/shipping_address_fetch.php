
<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if (!empty($_POST['user_id'])) {
 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
 		$sql = "SELECT * FROM `shipping_address` WHERE `user_id`='$user_id' ORDER BY `id` DESC";
 		if ($res = $connection->query($sql)) {
 			if ($res->num_rows > 0) {

 				while($row = $res->fetch_assoc()){
 					$data[]=[
	 					'id' => $row['id'],
	 					'user_id' => $row['user_id'],
	 					'state' => $row['state'],
	 					'city' => $row['city'],
	 					'address' => $row['location'],
	 					'mobile' => $row['mobile'],
	 					'email' => $row['email'],
	 					'pin' => $row['pin'],
 					];
 				}
 				
 				$response =[
				"status" => true,
				'message' => 'Shipping Address List',
				'data' => $data,
				];
				http_response_code(200);
				echo json_encode($response);
				die();
 			}else{
 				$data = [];
 				$response =[
				"status" => false,
				'message' => 'No Address Found Please Add New Shipping Address',
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
				'data' => $data,
				];
				http_response_code(200);
				echo json_encode($response);
				die();

 	}
?>