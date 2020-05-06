<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if (!empty($_POST['user_id'])) {
 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
 		$sql_orders = "SELECT * FROM `orders` WHERE `user_id`='$user_id' ORDER BY `id` DESC";
 		if ($res_order = $connection->query($sql_orders)) {
 		    if($res_order->num_rows > 0){
 			while($row_orders = $res_order->fetch_assoc()) {

 				$sql_ord_details = "SELECT `product`.`name` AS p_name, `product`.`image` AS p_image,`order_details`.`price` AS o_price, `order_details`.`quantity` AS o_quantity,`order_details`.`price` AS o_price,`order_details`.`total_cashback` AS total_cashback,`order_details`.`date` AS dates,`order_details`.`time` AS timedate  FROM `order_details` INNER JOIN `product` ON `product`.`id` = `order_details`.`p_id` WHERE `order_id` = '$row_orders[id]'";
 				if($res_ord_details= $connection->query($sql_ord_details)){
 					unset($ord_details); 
 					while($row_ord_details = $res_ord_details->fetch_assoc()) {
 						$ord_details[] = [
 							'product_name' => $row_ord_details['p_name'] ,
 							'product_image' => $row_ord_details['p_image'] ,
 							'order_price' => $row_ord_details['o_price'] ,
							'order_quantity' => $row_ord_details['o_quantity'] ,
							'total_cashback' => $row_ord_details['total_cashback'] ,
							'date' => $row_ord_details['dates'] ,
							'time' => $row_ord_details['timedate'] ,
 						];
 					}
 				}
 				$order[] = [
 					'id' => $row_orders['id'],
 					'total' => $row_orders['amount'],
 					'cashback' => $row_orders['cashback'],
 					'wallet_pay' => $row_orders['wallet_pay'],
 					'payable_amount' => $row_orders['total'],
					 'delivery_status' => $row_orders['status'],
					 'date' => $row_orders['date'] ,
					 'time' => $row_orders['time'] ,
 					'products' => $ord_details,
 					];
 			}
 		    }else{
 		        $order = [];
 		    }
 			$response =[
				"status" => true,
				'message' => 'Order History',
				'code' => 200,
				'data' => $order,
				];
				http_response_code(200);
				echo json_encode($response);
				die();
 			
 		}else{
 			$data = [];
 			$response =[
				"status" => false,
				'message' => 'Something Went Wrong',
				'code' => 400,
				'data' => $data,
				];
				http_response_code(400);
				echo json_encode($response);
				die();
 		}
 	}else{
 		$data = [];
 		$response =[
				"status" => false,
				'message' => 'Please Check Required Fields',
				'code' => 400,
				'data' => $data,
				];
				http_response_code(400);
				echo json_encode($response);
				die();
 	}


// function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
// function mysql_fix_string($string){
//     if (get_magic_quotes_gpc()) 
//         $string = stripslashes($string);
//     return $string;
// }
?>