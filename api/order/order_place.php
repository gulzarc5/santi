<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
	 header("content-type: application/json");
	 date_default_timezone_set('Asia/Kolkata');

 	if (!empty($_POST['user_id']) && !empty($_POST['shipping_address_id'])) {

 		//All Form Data Stored In Variable
 		$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
 		$shipping_address_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['shipping_address_id']));

 		// If wallet status 2 then pay from wallet else dont use wallet
 		$wallet_status = $connection->real_escape_string(mysql_entities_fix_string($_POST['wallet_status']));
 		//Store Date And Time In A Variable with specified time zone
 		
 		$date = date('Y-m-d');
	 	$time = date('H:i:s');

	 	// Fetch Cart Items For Order
 		$sql_cart = "SELECT * FROM `cart` WHERE `u_id`='$user_id'";
 		if ($res_cart = $connection->query($sql_cart)) {

 			//If cart Is Not Empty Then Place Order
 			if ($res_cart->num_rows > 0) {

 				//Create Order Id For Placing Order
 				$order_create_sql = "INSERT INTO `orders`(`id`, `user_id`, `shipping_address_id`, `amount`, `wallet_pay`, `total`, `date`, `time`, `status`) VALUES (null,'$user_id','$shipping_address_id',null,null,null,'$date','$time','1')";
 				// Declare A Variable For Counting Amount OF Order
 				$total_amount = 0;
 				$discountable_amount = 0;

 				if ($order_res_sql = $connection->query($order_create_sql) ) {
 					//Order Id Stored In A Variable For Placing Order Agains Items
 					$order_id = $connection->insert_id;

 					//Fetch Cart Items Row By Row 
 					while ($row_cart = $res_cart->fetch_assoc()) {
 						//Fetch Product Price For Placing An Order
 						$sql_price = "SELECT `price`,`stock`,`sub_cat_id`,`cash_back` FROM `product` WHERE `id`='$row_cart[p_id]'";
 						if ($res_price = $connection->query($sql_price)) {
 							//Price From Product Table
 							$row_price = $res_price->fetch_assoc();
 							$price_product = $row_price['price'];
 							$single_price = floatval($price_product) * $row_cart['quantity'];
 							$total_amount = floatval($total_amount) + $single_price;
 							if (($row_price['sub_cat_id'] != 22) && ($row_price['sub_cat_id'] != 23)) {
 								$discountable_amount = floatval($discountable_amount) + $single_price;
 							}
 							$order_details_sql = "INSERT INTO `order_details`(`id`, `user_id`, `order_id`, `p_id`, `price`, `quantity`, `date`, `time`) VALUES (null,'$user_id','$order_id','$row_cart[p_id]','$price_product','$row_cart[quantity]','$date','$time')";
 							$stock = $row_price['stock'] - $row_cart['quantity'];
		 					if ($res_order_details = $connection->query($order_details_sql)) {
		 						$sql_stock_update = "UPDATE `product` SET `stock` = '$stock' WHERE `id` = '$row_cart[p_id]'";
		 						if ($res_stock_update = $connection->query($sql_stock_update)) {}
		 					}		 					
 						}

 					}
 						/// After successfully insertion of order details Update Order with total amount
 						$Payable_amount = $total_amount;
 						$wallet_pay = 0;
 						/// If User Requests For Wallet Payment
 						if ($wallet_status == 2) {

 							$wallet_amount_sql = "SELECT * FROM `wallet` WHERE `user_id`='$user_id' AND `status` = '1'";
 							if ($res_wallet_amount = $connection->query($wallet_amount_sql)) {

 								if ($res_wallet_amount->num_rows > 0) {
 								
	 								$wallet_amount_row = $res_wallet_amount->fetch_assoc();
	 								if ($wallet_amount_row['amount'] > $Payable_amount) {
	 									$wallet_amount = floatval($wallet_amount_row['amount']) - floatval($total_amount);
	 									$sql_update_wallet = "UPDATE `wallet` SET `amount`='$wallet_amount' WHERE `user_id` = '$user_id'";
	 									if ($res_wallet_update = $connection->query($sql_update_wallet)) {}
	 									$sql_wallet_history = "INSERT INTO `wallet_history`(`id`, `user_id`,`wallet_id`, `transaction_type`, `amount`,`total`, `comments`, `date`, `time`) VALUES (null,'$user_id','$wallet_amount_row[id]','1','$total_amount','$wallet_amount','Product Purchased Using Wallet','$date','$time')";
	 									if ($res_wallet_history = $connection->query($sql_wallet_history)) {}
	 									$wallet_pay = $total_amount;
	 									$Payable_amount = 0;

	 								}elseif($wallet_amount_row['amount'] > 0){
	 									$sql_update_wallet = "UPDATE `wallet` SET `amount`='0' WHERE `user_id` = '$user_id'";
	 									if ($res_wallet_update = $connection->query($sql_update_wallet)) {
	 										# code...
	 									}
	 									$sql_wallet_history = "INSERT INTO `wallet_history`(`id`, `user_id`, `wallet_id`, `transaction_type`, `amount`,`total`, `comments`, `date`, `time`) VALUES (null,'$user_id','$wallet_amount_row[id]','1','$wallet_amount_row[amount]','0','Product Purchased Using Wallet','$date','$time')";
	 									
	 									if ($res_wallet_history = $connection->query($sql_wallet_history)) {
	 										# code...
	 									}
	 									
	 									$Payable_amount = floatval($Payable_amount) - floatval($wallet_amount_row['amount']);

	 									$wallet_pay = $wallet_amount_row['amount'];

	 								
	 								}
 								}
 								// CHeck Order Amount is greater then 3000 or not if yes then apply discount
 								$discount = 0;
 								if ($total_amount >= 3000) {
 									$sql_discount = "SELECT `percentage` FROM `offer` WHERE `offer_type`='1'";
 									if ($res_discount = $connection->query($sql_discount)) {
 										$row_discount = $res_discount->fetch_assoc();
 										$data_discount = floatval($row_discount['percentage']);
 										$discount = ( $total_amount * floatval($data_discount)) / 100;
 										$Payable_amount = floatval($Payable_amount) - floatval($discount);
 									}
 								}

 								$sql_update_order = "UPDATE `orders` SET `amount`='$total_amount',`discount`='$discount',`discountable_amount`='$discountable_amount',`wallet_pay`='$wallet_pay',`total`='$Payable_amount' WHERE `id`='$order_id'";
 								if ($res_order_update = $connection->query($sql_update_order)) {
 									$sql_cart_delete = "DELETE FROM `cart` WHERE `u_id`='$user_id'";
 									$connection->query($sql_cart_delete);
 								}

 							}
 						}else{
 							$discount = 0;
 							$Payable_amount = $total_amount;
 								if ($total_amount >= 3000) {
 									$sql_discount = "SELECT `percentage` FROM `offer` WHERE `offer_type`='1'";
 									if ($res_discount = $connection->query($sql_discount)) {
 										$row_discount = $res_discount->fetch_assoc();
 										$data_discount = floatval($row_discount['percentage']);
 										$discount = ( $total_amount * floatval($data_discount)) / 100;
 										$Payable_amount = floatval($Payable_amount) - $discount;
 									}
 								}

 							$sql_update_order = "UPDATE `orders` SET `amount`='$total_amount',`discount`='$discount',`discountable_amount`='$discountable_amount',`wallet_pay`='0',`total`='$Payable_amount' WHERE `id`='$order_id'";
 							if ($res_order_update = $connection->query($sql_update_order)) {
 									$sql_cart_delete = "DELETE FROM `cart` WHERE `u_id`='$user_id'";
 									$connection->query($sql_cart_delete);
 							}

 						}
 					$response =[
					"status" => true,
					'message' => 'Order Placed successfully',
					'code' => 200,
					];
					http_response_code(200);
					echo json_encode($response);
					die();
 					
 				}else{
 					$response =[
					"status" => false,
					'message' => 'Something Went Wrong',
					'code' => 400,
					];
					http_response_code(400);
					echo json_encode($response);
					die();
 				}


 			}else{
 				$response =[
				"status" => false,
				'message' => 'Sorry We Cant Place an Order Your Cart Is Empty',
				'code' => 400,
				];
				http_response_code(400);
				echo json_encode($response);
				die();
 			}
 		}else{
 			$response =[
				"status" => false,
				'message' => 'Something Went Wrong Please Check Cart',
				'code' => 400,
				];
				http_response_code(400);
				echo json_encode($response);
				die();
 		}

 	
 	}else{
 		$response =[
				"status" => false,
				'message' => 'Please Check Required Fields',
				'code' => 400,
				];
				http_response_code(400);
				echo json_encode($response);
				die();
 	}

?>