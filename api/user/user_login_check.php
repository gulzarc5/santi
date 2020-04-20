<?php
	include_once '../../php/database/connection.php';
 	header("content-type: application/json");

 	if(isset($_POST['email']) && !empty($_POST['email']) && !empty($_POST['password'])){
 		$email = $connection->real_escape_string(mysql_entities_fix_string($_POST['email']));
    	$password = $connection->real_escape_string(mysql_entities_fix_string($_POST['password']));

    	$user_sql = "SELECT * FROM `users` WHERE `email`='$email' AND `user_type`= '2'";
    	if ($user_res = $connection->query($user_sql)) {
    		$user=$user_res->fetch_assoc();
    		if ($user_res->num_rows > 0) {
    			if ($user['status'] == '2') {
    				$data = [];
    				$response =[
						"status" => false,
						'message' => 'Sorry Your Account is Deactivated Please Contact Administrator',
						'code' => 200,
						'data' =>$data_user,
					];
					http_response_code(200);
					echo json_encode($response,JSON_NUMERIC_CHECK);
					die();
    			}else{
    			if (password_verify($password,$user['password'])){
	    			$api_key_sql = "DELETE FROM `api_key` WHERE `user_id`='$user[id]'";
	    			if ($connection->query($api_key_sql)) {    				# code...
	    			}
	    			$key = uniqid('api');
	    			$api_key_sql = "INSERT INTO `api_key`(`id`, `user_id`, `api_key`, `date`) VALUES (null,'$user[id]','$key',date('now'))";
	    			if ($connection->query($api_key_sql)) {
	    				$data_user = [
	    				'user_id' => $user['id'],
	    				'api_key'=> $key,
	    				'name' => $user['name'],
	    				'email' => $user['email'],
	    				'mobile' => $user['mobile'],
	    			];
	    			}
	    			
	    			$response =[
						"status" => true,
						'message' => 'Login Successfull',
						'code' => 200,
						'data' =>$data_user,
					];
					http_response_code(200);
					echo json_encode($response,JSON_NUMERIC_CHECK);
					die();
	    		}else{
	    			$response =[
						"status" => false,
						'message' => 'Password Does Not Matched',
						'code' => 400,
						'data' =>null,
					];
					http_response_code(400);
					echo json_encode($response,JSON_NUMERIC_CHECK);
					die();
	    		}
	    	}
    		}else{
    			$response =[
						"status" => false,
						'message' => 'User Not Found',
						'code' => 400,
						'data' =>null,
					];
					http_response_code(400);
					echo json_encode($response,JSON_NUMERIC_CHECK);
					die();
    		}
    		
    	}else{
    		$response =[
					"status" => false,
					'message' => 'Something Went Wrong Please try Again',
					'code' => 400,
					'data' =>null,
				];
			http_response_code(400);
			echo json_encode($response,JSON_NUMERIC_CHECK);
			die();
    	}
 	}else{
 		$response =[
					"status" => false,
					'message' => 'Email And Password Can Not Be Empty',
					'code' => 400,
					'data' =>null,
				];
		http_response_code(400);
		echo json_encode($response,JSON_NUMERIC_CHECK);
 	}


function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
	function mysql_fix_string($string){
	    if (get_magic_quotes_gpc()) 
	        $string = stripslashes($string);
	    return $string;
	}
	
	
	
?>