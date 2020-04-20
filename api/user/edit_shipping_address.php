
<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if (!empty($_POST['user_id']) && !empty($_POST['address_id'])) {
 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
 		$address_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['address_id']));
 		$sql = "SELECT * FROM `shipping_address` WHERE `id`='$address_id'";
 		if ($res = $connection->query($sql)) {
 			if ($res->num_rows > 0) {
 				$row = $res->fetch_assoc();
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
 				
 				$response =[
				"status" => true,
				'message' => 'Shipping Address List',
				'data' => $data,
				];
				http_response_code(200);
				echo json_encode($response);
				die();
 			}else{
 				$response =[
				"status" => false,
				'message' => 'No Address Found Please Add New Shipping Address',
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
				'data' =>null,
            ];
            http_response_code(200);
            echo json_encode($response);
            die();

 	}
?>