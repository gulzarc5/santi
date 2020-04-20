<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if (!empty($_POST['name'])) {
 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
 		$name = $connection->real_escape_string(mysql_entities_fix_string($_POST['name']));
 		$email = $connection->real_escape_string(mysql_entities_fix_string($_POST['email']));
 		// $referal_code = $connection->real_escape_string(mysql_entities_fix_string($_POST['referal_code']));
 		// $mobile = $connection->real_escape_string(mysql_entities_fix_string($_POST['mobile']));
 		$state = $connection->real_escape_string(mysql_entities_fix_string($_POST['state']));
 		$city = $connection->real_escape_string(mysql_entities_fix_string($_POST['city']));
 		$address = $connection->real_escape_string(mysql_entities_fix_string($_POST['address']));
 		$pin = $connection->real_escape_string(mysql_entities_fix_string($_POST['pin']));
 		
 		$sql_email_check = "SELECT * FROM `users` WHERE `email`='$email'";
 		if ($res_email_check = $connection->query($sql_email_check)) {
 			if ($res_email_check->num_rows > 0) {
 				$email_check_row = $res_email_check->fetch_assoc();
 				if ($user_id != $email_check_row['id']) {
 					$response =[
					"status" => false,
					'message' => 'Email Id Already Exist',
					];
					http_response_code(200);
					echo json_encode($response);
					die();
 				}
 			}
 		}
 		
 		$update_profile = "UPDATE `users` SET `name`='$name',`email`='$email',`state`='$state',`city`='$city',`address`='$address' WHERE `id`='$user_id'";
 		
 		if ($res_profile = $connection->query($update_profile)) {
 			# code...
 		}

 		if (empty($pin)) {
 			$update_address = "UPDATE `parmanent_address` SET `state`='$state',`city`='$city',`location`='$address',`pin`=null WHERE `user_id`='$user_id'";
 		}else{
 			$update_address = "UPDATE `parmanent_address` SET `state`='$state',`city`='$city',`location`='$address',`pin`='$pin' WHERE `user_id`='$user_id'";
 		}
 		
 		if ($res_address = $connection->query($update_address)) {
 			# code...
 		}
 		if ($res_profile) {
 			# code...
 		}
 		$response =[
				"status" => true,
				'message' => 'Profile Updated Successfully',
				'code' => 200,
				];
				http_response_code(200);
				echo json_encode($response);
				die();
 		
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