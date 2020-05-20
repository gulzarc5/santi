
<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");
    date_default_timezone_set('Asia/Kolkata');

 	if (!empty($_POST['user_id']) && !empty($_POST['page_no'])) {
        $user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
        $page = $connection->real_escape_string(mysql_entities_fix_string($_POST['page_no']));
        $month = date('m');
        $year = date('Y');
        
        // Check product is already addedd in star order of current month or not
        $check_current_month_star_sql = "SELECT * FROM `orders_star` WHERE MONTH(created_at) = '$month' AND YEAR(created_at) = '$year' AND `user_id`='$user_id'";
        if ($res_check_current_month_star = $connection->query($check_current_month_star_sql)) {
            if ($res_check_current_month_star->num_rows > 0) {
                $total_rows = $res_check_current_month_star->num_rows;
                $total_page = ceil($total_rows/10);
                $limit = ($page*10)-10;

                $star_product_sql = "SELECT `orders_star`.`created_at` as purchase_date, `product`.`name` AS p_name, `product`.`mrp` AS mrp,`product`.`price` AS price, `product`.`image` as image FROM `orders_star` LEFT JOIN `product` ON `product`.`id` = `orders_star`.`p_id` WHERE  MONTH(`orders_star`.created_at) = '$month' AND YEAR(`orders_star`.created_at) = '$year' AND `orders_star`.`user_id`='$user_id' ORDER BY `orders_star`.`id` DESC LIMIT $limit,10";
                if ($res_star_product = $connection->query($star_product_sql)) {
                    $data = $res_star_product -> fetch_all(MYSQLI_ASSOC);
                    $response =[
                        "status" => true,
                        'message' => 'Star Product purchase List',
                        'total_page' => $total_page,
                        'data' => $data,
                        ];
                    http_response_code(200);
                    echo json_encode($response);
                    die();
                } else {
                    $response =[
                        "status" => true,
                        'message' => 'Star Product purchase List',
                        'total_page' => 1,
                        'data' => [],
                        ];
                    http_response_code(200);
                    echo json_encode($response);
                    die();
                }
            }else{
                
 				$response =[
                    "status" => true,
                    'message' => 'Star Product purchase List',
                    'total_page' => 1,
                    'data' => [],
                    ];
                http_response_code(200);
                echo json_encode($response);
                die();
            }
        }else{
            $response =[
                "status" => false,
                'message' => 'Something Went Wrong Please Try Again',
                'total_page' => 1,
                'data' => [],
            ];
            http_response_code(200);
            echo json_encode($response);
            die();
        } 
 	}else{
 		$response =[
            "status" => false,
            'message' => 'Please Check Required Fields',
            'total_page' => 1,
            'data' => [],
        ];
        http_response_code(200);
        echo json_encode($response);
        die();

 	}
?>