<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if (!empty($_POST['user_id'])) {

 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
 		
 		$sql = "SELECT `cart`.`id` AS cart_id, `cart`.`quantity` as cart_quantity, `product`.`name` AS p_name, `product`.`price` AS p_price,`product`.`id` as p_id, `product`.stock as p_stock, `product`.`image` AS p_image FROM `cart` INNER JOIN `product` ON `product`.`id`=`cart`.`p_id` WHERE `cart`.`u_id`='$user_id'";

 		if ($res = $connection->query($sql)) {
 			if ($res->num_rows > 0) {
 				while($cart_row = $res->fetch_assoc()){

 					$data[]=[
 						'cart_id' => $cart_row['cart_id'],
 						'product_id' => $cart_row['p_id'],
 						'name' => $cart_row['p_name'],
 						'image' => $cart_row['p_image'],
 						'quantity' => $cart_row['cart_quantity'],
 						'price' => $cart_row['p_price'],
 						'stock' => $cart_row['p_stock'],
 					];
 				}
 				$response =[
				"status" => true,
				'message' => 'Item Added In The Cart',
				'code' => 200,
				'data' => $data,
				];
				http_response_code(200);
				echo json_encode($response);
 			}else{
 				$data=[];
 				$response =[
				"status" => true,
				'message' => 'No Items In The Cart',
				'code' => 200,
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
			'code' => 400,
			'data' => $data,
			];
			http_response_code(400);
			echo json_encode($response);
 		}

 	}else{
 		$data=[];
 		$response =[
			"status" => false,
			'message' => 'Required Field Can Not Be Empty',
			'code' => 400,
			'data' => $data,
		];
		http_response_code(400);
		echo json_encode($response);
 	}
 ?>