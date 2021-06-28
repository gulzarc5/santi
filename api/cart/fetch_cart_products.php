<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if (!empty($_POST['user_id'])) {

 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
 		
 		$sql = "SELECT `cart`.`id` AS cart_id, 
		 `cart`.`quantity` as cart_quantity,
		 `product`.`name` as p_name,
		 `product`.`mrp` as mrp,
		 `product`.`price` as price,
		 `product`.`cash_back` as cash_back,
		 `product`.`promotional_bonus` as promotional_bonus,
		 `product`.`image` as p_image,
		 `product`.`stock` as p_stock,
		 `product`.`is_star_product` as p_is_star_product,
		 `product`.`expiry_date` as p_expiry_date
		 FROM `cart` INNER JOIN `product` ON `product`.`id`=`cart`.`p_id` 
		 WHERE `cart`.`u_id`='$user_id'";

 		if ($res = $connection->query($sql)) {
 			if ($res->num_rows > 0) {
 				while($cart_row = $res->fetch_assoc()){

 					$data[]=$cart_row;
 				}
 				$response =[
				"status" => true,
				'message' => 'Item Added In The Cart',
				'data' => $data,
				];
				http_response_code(200);
				echo json_encode($response);
 			}else{
 				$data=[];
 				$response =[
				"status" => true,
				'message' => 'No Items In The Cart',
				'data' => $data,
				];
				http_response_code(200);
				echo json_encode($response);
 			}
 		
 		}else{
 			$data=[];
 			$response =[
			"status" => false,
			'message' => 'Something Went Wrong',
			'data' => $data,
			];
			http_response_code(200);
			echo json_encode($response);
 		}

 	}else{
 		$data=[];
 		$response =[
			"status" => false,
			'message' => 'Required Field Can Not Be Empty',
			'data' => $data,
		];
		http_response_code(200);
		echo json_encode($response);
 	}
 ?>