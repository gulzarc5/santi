<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
	 header("content-type: application/json");
	 date_default_timezone_set('Asia/Kolkata');

 	if (!empty($_POST['user_id']) && !empty($_POST['star'])) {
 		
 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
 		$star = $connection->real_escape_string(mysql_entities_fix_string($_POST['star']));
 		$comments = $connection->real_escape_string(mysql_entities_fix_string($_POST['comments']));
 		$date = date('Y-m-d');
 		$sql = "INSERT INTO `customer_review`(`id`, `user_id`, `comments`, `star`, `status`, `create_at`) VALUES (null,'$user_id','$comments','$star','1','$date')";
 		if ($res = $connection->query($sql)) {
 			$response =[
				"status" => true,
				'message' => 'Thank You For Your Valuable feedback',
				];
				http_response_code(200);
				echo json_encode($response);
				die();
 		}else{
 			$response =[
				"status" => false,
				'message' => 'Sorry Something Went Wrong',
				];
				http_response_code(200);
				echo json_encode($response);
				die();
 		}
 	}else{
 		$response =[
				"status" => false,
				'message' => 'Please Fill the Form Properly',
				];
				http_response_code(200);
				echo json_encode($response);
				die();
 	}

 ?>