
<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if (!empty($_POST['user_id'])) {
 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
 		 $sql_u_fetch = "SELECT * FROM `users` WHERE `parent_id`='$user_id'";
            if ($res_u = $connection->query($sql_u_fetch)) {
            	if ($res_u->num_rows > 0) {
            		while($user_row = $res_u->fetch_assoc()){
                            
                            $data[] =[
                            	'id' => $user_row['id'],
                            	'name' => $user_row['name'],
                            	'mobile' => $user_row['mobile'],
                            ];             
                	}
                	$response =[
							"status" => true,
							'message' => 'Downline List',
							'data'=> $data,
							];
						http_response_code(200);
						echo json_encode($response);
						die(); 

            	}else{
            		$data = [];
			 		$response =[
							"status" => false,
							'message' => 'No Downlines Found',
							'data'=> $data,
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
					'data'=> $data,
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
			'data'=> $data,
		];
		http_response_code(200);
		echo json_encode($response);
		die();
 	}

 
 ?>