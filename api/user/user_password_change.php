<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if(isset($_POST['user_id']) && !empty($_POST['current_password']) && !empty($_POST['new_password']) ){
 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
        $current_password = $connection->real_escape_string(mysql_entities_fix_string($_POST['current_password']));
        $new_password = $connection->real_escape_string(mysql_entities_fix_string($_POST['new_password']));

    	$user_sql = "SELECT * FROM `users` WHERE `id`='$user_id'";
    	if ($user_res = $connection->query($user_sql)) {
    		$user=$user_res->fetch_assoc();
            if ($user_res->num_rows > 0){
                if (password_verify($current_password,$user['password'])){

                   $password = password_hash($new_password, PASSWORD_BCRYPT);

                   $sql_change = "UPDATE `users` SET `password`='$password' WHERE `id`='$user_id'";
                   if ($res_change = $connection->query($sql_change)) {
                       $response =[
                        "status" => true,
                        'message' => 'Password Changed Successfully',
                        'code' => 200,
                        ];
                        http_response_code(200);
                        echo json_encode($response,JSON_NUMERIC_CHECK);
                        die();
                   }else{
                     $response =[
                        "status" => false,
                        'message' => 'Something Went Wrong',
                        'code' => 400,
                    ];
                    http_response_code(400);
                    echo json_encode($response,JSON_NUMERIC_CHECK);
                    die();
                   }
                    
                   
                }else{
                    $response =[
                        "status" => false,
                        'message' => 'Password Does Not Matched',
                        'code' => 400,
                    ];
                    http_response_code(400);
                    echo json_encode($response,JSON_NUMERIC_CHECK);
                    die();
                }
            }else{
                $response =[
                        "status" => false,
                        'message' => 'User Not Found',
                        'code' => 400,
                    ];
                    http_response_code(400);
                    echo json_encode($response,JSON_NUMERIC_CHECK);
                    die();
            }
        }else{
            $response =[
                        "status" => false,
                        'message' => 'Something Went Wrong',
                        'code' => 400,
                    ];
                    http_response_code(400);
                    echo json_encode($response,JSON_NUMERIC_CHECK);
                    die();
        }
 	}else{
 		$response =[
					"status" => false,
					'message' => 'Required Field Can Not Be Empty',
					'code' => 400,
					'data' =>null,
				];
		http_response_code(400);
		echo json_encode($response,JSON_NUMERIC_CHECK);
 	}




	
?>