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
		$wallet_status_chk = $connection->real_escape_string(mysql_entities_fix_string($_POST['wallet_status']));
		//Store Date And Time In A Variable with specified time zone

		$wallet_status = 1 ;
		$user_sql = "SELECT * FROM `users` WHERE `id`='$user_id'";
		if ($res_user_data = $connection->query($user_sql)) {
			$user_row = $res_user_data->fetch_assoc();
			if ($user_row['is_star'] == '2') {
				$wallet_balance_sql = "SELECT * FROM `wallet` WHERE `user_id`='$user_id'";
				if ($res_wallet_balance_sql = $connection->query($wallet_balance_sql)) {
					$row_wallet_balance_data = $res_wallet_balance_sql->fetch_assoc();
					if (($row_wallet_balance_data['status'] == '1') && ($row_wallet_balance_data['amount'] > 0 ) && ($wallet_status_chk == '2')) {
						$wallet_status = 2 ;
					}
				}
			}
		}
		
 		$date = date('Y-m-d');
	 	$time = date('H:i:s');

	 	// Fetch Cart Items For Order
 		$sql_cart = "SELECT * FROM `cart` WHERE `u_id`='$user_id'";
 		if ($res_cart = $connection->query($sql_cart)) {

 			//If cart Is Not Empty Then Place Order
 			if ($res_cart->num_rows > 0) {

 				//Create Order Id For Placing Order
				$order_create_sql = "INSERT INTO `orders`(`user_id`,`shipping_address_id`,`date`,`time`, `status`,`order_from`) VALUES ('$user_id','$shipping_address_id','$date','$time','1','1')";
 				// Declare A Variable For Counting Amount OF Order
 				$total_amount = 0;
				$total_cgst = 0;
				$total_sgst = 0;
				$total_cashback = 0;
				$total_promotional_bonus = 0;

 				if ($order_res_sql = $connection->query($order_create_sql) ) {
 					//Order Id Stored In A Variable For Placing Order Agains Items
 					$order_id = $connection->insert_id;

 					//Fetch Cart Items Row By Row 
 					while ($row_cart = $res_cart->fetch_assoc()) {
 						//Fetch Product Price For Placing An Order
 						$sql_price = "SELECT `price`,`stock`,`cgst`,`sgst`,`sub_cat_id`,`cash_back`,`promotional_bonus` FROM `product` WHERE `id`='$row_cart[p_id]'";
 						if ($res_price = $connection->query($sql_price)) {
 							//Price From Product Table
							$row_price = $res_price->fetch_assoc();
							$price_product = $row_price['price'];
							$single_price = floatval($price_product) * $row_cart['quantity'];

							$single_cgst = floatval($row_price['cgst']) * $row_cart['quantity'];
							$single_sgst = floatval($row_price['sgst']) * $row_cart['quantity'];							
							$single_cashback = floatval($row_price['cash_back']) * $row_cart['quantity'];
							$single_promotional_bonus = floatval($row_price['promotional_bonus']) * $row_cart['quantity'];

							$total_cgst = $total_cgst+$single_cgst;
							$total_sgst = $total_sgst+$single_sgst;
							$total_cashback = $total_cashback+$single_cashback;							
							$total_promotional_bonus = $total_promotional_bonus+$single_promotional_bonus;

							$total_amount = floatval($total_amount) + ($single_price);
							 
							$order_details_sql = "INSERT INTO `order_details`(`id`, `user_id`, `order_id`, `p_id`, `price`, `quantity`,`cashback`,`sgst`,`cgst`,`total_sgst`,`total_cgst`,`total_cashback`,`total_amount`, `date`, `time`,`order_from`) VALUES (null,'$user_id','$order_id','$row_cart[p_id]','$price_product','$row_cart[quantity]','$row_price[cash_back]','$row_price[cgst]','$row_price[sgst]','$single_sgst','$single_cgst','$single_cashback','$single_price','$date','$time','1')";

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

	 								}elseif($wallet_amount_row['amount'] > 0 && $wallet_amount_row['amount'] < $Payable_amount){
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

								$sql_update_order = "UPDATE `orders` SET `amount`='$total_amount',`wallet_pay`='$wallet_pay',`sgst` = '$total_sgst',`cgst` = '$total_cgst',`total`='$Payable_amount',`cashback`='$total_cashback' WHERE `id`='$order_id'";

 								if ($res_order_update = $connection->query($sql_update_order)) {
 									$sql_cart_delete = "DELETE FROM `cart` WHERE `u_id`='$user_id'";
 									$connection->query($sql_cart_delete);
 								}

 							}
 						}else{
							$sql_update_order = "UPDATE `orders` SET `amount`='$total_amount',`wallet_pay`='0',`sgst` = '$total_sgst',`cgst` = '$total_cgst',`total`='$Payable_amount',`cashback`='$total_cashback' WHERE `id`='$order_id'";

 							if ($res_order_update = $connection->query($sql_update_order)) {
 									$sql_cart_delete = "DELETE FROM `cart` WHERE `u_id`='$user_id'";
 									$connection->query($sql_cart_delete);
 							}

 						}
 					$response =[
					"status" => true,
					'message' => 'Order Placed successfully',
					];
					http_response_code(200);
					echo json_encode($response);
					die();
 					
 				}else{
 					$response =[
					"status" => false,
					'message' => 'Something Went Wrong',
					];
					http_response_code(200);
					echo json_encode($response);
					die();
 				}


 			}else{
 				$response =[
				"status" => false,
				'message' => 'Sorry We Cant Place an Order Your Cart Is Empty',
				];
				http_response_code(200);
				echo json_encode($response);
				die();
 			}
 		}else{
 			$response =[
				"status" => false,
				'message' => 'Something Went Wrong Please Check Cart',
				];
				http_response_code(200);
				echo json_encode($response);
				die();
 		}

 	
 	}else{
 		$response =[
				"status" => false,
				'message' => 'Please Check Required Fields',
				];
				http_response_code(200);
				echo json_encode($response);
				die();
 	}

?>