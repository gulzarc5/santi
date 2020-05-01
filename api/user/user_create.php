<?php
	include_once '../../php/database/connection.php';
	// include_once '../security/device_id_check';
	 header("content-type: application/json");
	 date_default_timezone_set('Asia/Kolkata');

 	if (!empty($_POST['name']) && !empty($_POST['mobile']) && !empty($_POST['email']) && !empty($_POST['password'])) {
 		$name = $connection->real_escape_string(mysql_entities_fix_string($_POST['name']));
 		$email = $connection->real_escape_string(mysql_entities_fix_string($_POST['email']));
 		$referal_code = $connection->real_escape_string(mysql_entities_fix_string($_POST['referal_code']));
 		$mobile = $connection->real_escape_string(mysql_entities_fix_string($_POST['mobile']));
 		$state = $connection->real_escape_string(mysql_entities_fix_string($_POST['state']));
 		$city = $connection->real_escape_string(mysql_entities_fix_string($_POST['city']));
 		$address = $connection->real_escape_string(mysql_entities_fix_string($_POST['address']));
 		$pin = $_POST['pin'];
 	

 		$password = $connection->real_escape_string(mysql_entities_fix_string($_POST['password']));
 		$password = password_hash($password, PASSWORD_BCRYPT);
 		//$user_type = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_type']));

 		$sql_check = "SELECT * FROM `users` WHERE `email`='$email'";
 		if ($res_check = $connection->query($sql_check)) {
 			if ($res_check->num_rows > 0) {
 				$response =[
				"status" => false,
				'message' => 'Email Id Already Exist',
				'data' => null,
				];
				http_response_code(200);
				echo json_encode($response);
				die();
 			} 			
	 	}

	 	$sql_check_mobile = "SELECT * FROM `users` WHERE `mobile`='$mobile'";
 		if ($res_check_mobile = $connection->query($sql_check_mobile)) {
 			if ($res_check_mobile->num_rows > 0) {
 				$response =[
				"status" => false,
				'message' => 'Mobile Number Already Exist',
				'data' => null,
				];
				http_response_code(200);
				echo json_encode($response);
				die();
 			} 			
	 	}
	 	$ref_user_id = null;
	 	if (!empty($referal_code)) {
	 		$ref_user_sql = "SELECT * FROM `users` where `mobile`='$referal_code'";		 	
		 	if ($ref_user_res = $connection->query($ref_user_sql)) {
		 		if ($ref_user_res->num_rows < 1) {
		 			$response =[
					"status" => false,
					'message' => 'Referal Code Invalid',
					'data' => null,
					];
					http_response_code(200);
					echo json_encode($response);
					die();
		 		}else{
		 			$ref_user = $ref_user_res->fetch_assoc();
		 			$ref_user_id = $ref_user['id'];
		 		}
		 	}else{
		 		
	 				$response =[
					"status" => false,
					'message' => 'Referal Code Invalid',
					'data' => null,
					];
					http_response_code(200);
					echo json_encode($response);
					die();
	 					
		 	}
	 	}
		 $date = date('Y-m-d H:i:s');
	 	if (!empty($referal_code)) {
	 		$sql_insert = "INSERT INTO `users`(`id`, `parent_id`, `refferel`, `name`, `email`, `mobile`, `state`, `city`, `address`, `password`, `user_type`, `date`) VALUES (null,'$ref_user_id','$referal_code','$name','$email','$mobile','$state','$city','$address','$password','2','$date')";
	 	}else{
	 		$sql_insert = "INSERT INTO `users`(`id`, `parent_id`, `refferel`, `name`, `email`, `mobile`, `state`, `city`, `address`, `password`, `user_type`, `date`) VALUES (null,null,null,'$name','$email','$mobile','$state','$city','$address','$password','2','$date')";
	 	}
	 	
	 	
	 	if ($res_insert = $connection->query($sql_insert)) {

	 		$user_id = $connection->insert_id;
	 		$date = date('Y-m-d');
	 		$time = date('h:i:s');
	 		$sql_wallet = "INSERT INTO `wallet`(`id`, `user_id`, `amount`,`status`,`date`, `time`) VALUES (null,'$user_id','0','2','$date','$time')";
	 		if ($res_wallet = $connection->query($sql_wallet)) {
	 			# code...
	 		}

	 		if (!empty($pin)) {
	 			$sql_parmanent = "INSERT INTO `parmanent_address`(`id`, `user_id`, `state`, `city`, `location`, `pin`) VALUES (null,'$user_id','$state','$city','$address','$pin')";
	 		}else{
	 			$sql_parmanent = "INSERT INTO `parmanent_address`(`id`, `user_id`, `state`, `city`, `location`, `pin`) VALUES (null,'$user_id','$state','$city','$address',NULL)";
	 		}
	 		
	 		if ($res_parmanent = $connection->query($sql_parmanent)) {
	 			# code...
	 		}

	 		$key = uniqid('api');
	 	    $api_key_sql = "INSERT INTO `api_key`(`id`, `user_id`, `api_key`, `date`) VALUES (null,'$user_id','$key',date('now'))";
    			if ($connection->query($api_key_sql)) {
    				$data_user = [
    				'user_id' => $user_id,
    				'api_key'=> $key,
    				'name' => $name,
    				'email' => $email,
    				'mobile' => $mobile,
    			];
	 		}
	 		$response =[
				"status" => true,
				'message' => 'User Created Successfully',
				'data' => $data_user,
				];
				http_response_code(200);
				echo json_encode($response);
				die();
	 	}else{
	 		$response =[
				"status" => false,
				'message' => 'Something Went Wrong Please Try Again',
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

 	function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
	function mysql_fix_string($string){
	    if (get_magic_quotes_gpc()) 
	        $string = stripslashes($string);
	    return $string;
	}
	
?>