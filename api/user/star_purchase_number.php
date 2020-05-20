
<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");
    date_default_timezone_set('Asia/Kolkata');

 	if (!empty($_POST['user_id'])) {
         $user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
         
        $month = date('m');
        $year = date('Y');
        
        // Check product is already addedd in star order of current month or not
        $check_current_month_star_sql = "SELECT * FROM `orders_star` WHERE MONTH(created_at) = '$month' AND YEAR(created_at) = '$year' AND `user_id`='$user_id'";
        echo $check_current_month_star_sql;
        if ($res_check_current_month_star = $connection->query($check_current_month_star_sql)) {
            if ($res_check_current_month_star->num_rows > 0) {
                $response =[
                    "status" => true,
                    'message' => 'Star Product purchase Number',
                    'number' => $res_check_current_month_star->num_rows,
                ];
                http_response_code(200);
                echo json_encode($response);
                die();
            }else{
                
 				$response =[
                    "status" => true,
                    'message' => 'Star Product purchase Number',
                    'number' => 0,
                    ];
                http_response_code(200);
                echo json_encode($response);
                die();
            }
        }else{
            $response =[
                "status" => false,
                'message' => 'Something Went Wrong Please Try Again',
                'number' => 0,
            ];
            http_response_code(200);
            echo json_encode($response);
            die();
        } 
 	}else{
 		$response =[
            "status" => false,
            'message' => 'Please Check Required Fields',
            'number' => 0,
        ];
        http_response_code(200);
        echo json_encode($response);
        die();

 	}
?>