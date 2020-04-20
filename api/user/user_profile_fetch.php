<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if(isset($_POST['user_id'])){
 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));

    	$user_sql = "SELECT * FROM `users` WHERE `id`='$user_id'";
    	if ($user_res = $connection->query($user_sql)) {
    		$user=$user_res->fetch_assoc();
    		$parmanent = null;
    		$user_parmanent = "SELECT * FROM `parmanent_address` WHERE `user_id`='$user[id]'";
    		if ($res_parmanent = $connection->query($user_parmanent)) {

    			$row_parmanent = $res_parmanent->fetch_assoc();
    			$parmanent = [
    				'id'=> $row_parmanent['id'],
    				'state' => $row_parmanent['state'],
    				'city' => $row_parmanent['city'],
    				'location' => $row_parmanent['location'],
    				'pin' => $row_parmanent['pin'],
    			];
    		}
    	
    		$data_user = [
    				'user_id' => $user['id'],
    				'name' => $user['name'],
    				'email' => $user['email'],
    				'mobile' => $user['mobile'],
    				'parmanent_address' => $parmanent,
    			];    			
    		$response =[
					"status" => true,
					'message' => 'User Profile',
					'data' =>$data_user,
				];
			http_response_code(200);
			echo json_encode($response,JSON_NUMERIC_CHECK);
			die();
    		
    	}else{
    		$response =[
					"status" => false,
					'message' => 'Something Went Wrong Please try Again',
					'data' =>null,
				];
			http_response_code(200);
			echo json_encode($response,JSON_NUMERIC_CHECK);
			die();
    	}
 	}else{
 		$response =[
					"status" => false,
					'message' => 'User Id Can Not Be Empty',
					'data' =>null,
				];
		http_response_code(200);
		echo json_encode($response,JSON_NUMERIC_CHECK);
 	}




	
?>