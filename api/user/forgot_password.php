<?php
	include_once '../../php/database/connection.php';
	// include_once '../security/device_id_check';
 	header("content-type: application/json");


 	if ($_POST['email'] && !empty($_POST['email'])) {
 		$email = $connection->real_escape_string(mysql_entities_fix_string($_POST['email']));
 	
	$sql = "SELECT * FROM `users` WHERE `user_type`='2' AND `email`='$email'";
	if ($res = $connection->query($sql)) {

		if ($res->num_rows < 1) {
			$response =[
			"status" => false,
			'message' => 'Sorry Your Email Id Is Not Registered With Us',
			'code' => 200,
			];
			http_response_code(200);
			echo json_encode($response);
			die();
		}else{
			$row = $res->fetch_assoc();
			if ($row['status'] == '2') {
				$response =[
				"status" => false,
				'message' => 'Sorry Your Account Is Disabled Please Contact With Administrator',
				'code' => 200,
				'data' =>$sliders,
				];
				http_response_code(200);
				echo json_encode($response);
			}else{

				$to = $row['email'];
				$password = $connection->real_escape_string(mysql_entities_fix_string(randomPassword()));
				$pass = password_hash($password, PASSWORD_BCRYPT);
				$sql_update_pass = "UPDATE `users` SET `password`='$pass' WHERE `email`='$email'";
				if ($res_update_pass = $connection->query($sql_update_pass)) {
					$message = "<h1>Dear User</h1><br><h4>Your Password Is <b style='color:green'>$password</b></h4>";
					$name = $row['name'];
					$subject = "Password Request";
					sendMailEdu($to,$message,$subject,$name);

					$response =[
					"status" => true,
					'message' => 'Your Password Has Been Sent To Your Registered Email Please Check Your Email',
					'code' => 200,
					];
					http_response_code(200);
					echo json_encode($response);
				}else{
					$response =[
					"status" => true,
					'message' => 'Something Went Wrong Please Try Again',
					'code' => 200,
					'data' =>$sliders,
					];
					http_response_code(200);
					echo json_encode($response);
				}
				
			}
			
		}		 
		
	}else{
		$response =[
			"status" => false,
			'message' => 'Something Wrong',
			'code' => 200,
		];
		http_response_code(200);
		echo json_encode($response);
	}
}else{
		$response =[
			"status" => false,
			'message' => 'Something Wrong',
			'code' => 200,
		];
		http_response_code(200);
		echo json_encode($response);
}


function sendMailEdu($to,$message,$subjects,$name){
		require_once ('../email/SendGrid-API/vendor/autoload.php');

		/*Post Data*/
		// $name = $_POST['name'];
		// $email = $_POST['email'];
		// $message = $_POST['message'];
		// $page = $_POST['page'];

		/*Content*/
		$from = new SendGrid\Email("SANTIREKHA PASSWORD", "info@santirekha.com
		");
		$subject = $subjects;
		// $name = "ITZEN";
		$to = new SendGrid\Email($name, $to);
		$content = new SendGrid\Content("text/html", $message);

		/*Send the mail*/
		$mail = new SendGrid\Mail($from, $subject, $to, $content);
		$apiKey = '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';
		$sg = new \SendGrid($apiKey);

		/*Response*/
		$response = $sg->client->mail()->send()->post($mail);
		// var_dump($response);
		// return true;
	}	

	function randomPassword() {
	    $alphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	    $pass = array(); //remember to declare $pass as an array
	    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
	    for ($i = 0; $i < 8; $i++) {
	        $n = rand(0, $alphaLength);
	        $pass[] = $alphabet[$n];
	    }
	    return implode($pass); //turn the array into a string
	}

	function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
	function mysql_fix_string($string){
	    if (get_magic_quotes_gpc()) 
	        $string = stripslashes($string);
	    return $string;
	}
?>