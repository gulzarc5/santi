<?php
	include_once '../../php/database/connection.php';
 	header("content-type: application/json");
 	if (!empty($_POST['user_id'])) {
 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
 		$user_sql = "SELECT * FROM `users` WHERE `id`='$user_id' AND `user_type`= '2'";
 		if ($user_res = $connection->query($user_sql)) {
    		$user=$user_res->fetch_assoc();
    		if ($user_res->num_rows > 0) {
    			if ($user['status'] == '2') {
    				$response =[
						"status" => false,
						'message' => 'Sorry Your Account is Deactivated Please Contact Administrator',
						'code' => 200,
					];
					http_response_code(200);
					echo json_encode($response,JSON_NUMERIC_CHECK);
					die();
    			}else{
    				$response =[
						"status" => true,
						'message' => 'Account Is Active',
						'code' => 200,
					];
					http_response_code(200);
					echo json_encode($response,JSON_NUMERIC_CHECK);
					die();
    			}
    		}else{
    			$data = [];
		 		$response =[
							"status" => false,
							'message' => 'Sorry No Users Found',
							'code' => 200,
						];
				http_response_code(200);
				echo json_encode($response,JSON_NUMERIC_CHECK);
    		}
    	}else{
    		$data = [];
	 		$response =[
						"status" => false,
						'message' => 'Something Went Wrong',
						'code' => 400,
					];
			http_response_code(400);
			echo json_encode($response,JSON_NUMERIC_CHECK);
    	}

 	}else{
 		$data = [];
 		$response =[
					"status" => false,
					'message' => 'user_id Can Not Be Empty',
					'code' => 400,
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