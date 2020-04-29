<?php
	include "../admin_login_system/php_user_session_check.php";
	include "../database/connection.php";

 	if (isset($_SESSION['invoice_user'])  && !empty($_SESSION['invoice_user'])) {

 		$user_data = $_SESSION['invoice_user']; 		
 		if(is_numeric($user_data)){
			$sql = "SELECT * FROM `users` WHERE `mobile` = '$user_data'";
		}else{
			$sql = "SELECT * FROM `users` WHERE `email` = '$user_data'";
		}
		if ($res_sql = $connection->query($sql)) {
			if ($res_sql->num_rows > 0) {
				$user_row = $res_sql->fetch_assoc();
			}else{
				header("location:../../make_invoice_form.php?msg=6");
				die();
			}
		}else{
			header("location:../../make_invoice_form.php?msg=2");
			die();
		}

 		//All Form Data Stored In Variable
 		$wallet_status = '2';
 		$user_id = $user_row['id'];
 		if (isset($_SESSION['is_wallet'])) {
 			$wallet_status = $_SESSION['is_wallet']; // If iswallet 1 then pay from wallet 
 		}
 		

 		//Store Date And Time In A Variable with specified time zone
 		date_default_timezone_set('Asia/Kolkata');
 		$date = date('Y-m-d');
	 	$time = date('H:i:s');

	 	// Fetch temp_order Items For Order
 		$sql_temp_order = "SELECT * FROM `temp_invoice`";
 		if ($res_temp_order = $connection->query($sql_temp_order)) {

 			//If temp_order Is Not Empty Then Place Order
 			if ($res_temp_order->num_rows > 0) {

 				//Create Order Id For Placing Order
 				$order_create_sql = "INSERT INTO `orders`(`user_id`,`date`,`time`, `status`,`order_from`) VALUES ('$user_id','$date','$time','2','2')";
 				// Declare A Variable For Counting Amount OF Order
				$total_amount = 0;
				$total_cgst = 0;
				$total_sgst = 0;
				$total_cashback = 0;
				$total_promotional_bonus = 0;

 				if ($order_res_sql = $connection->query($order_create_sql) ) {
					$order_id = $connection->insert_id;
					
 					//Fetch Temporary Order Items Row By Row 
 					while ($row_temp_order = $res_temp_order->fetch_assoc()) {
 						//Fetch Product Price For Placing An Order
 						$sql_price = "SELECT `price`,`stock`,`cgst`,`sgst`,`sub_cat_id`,`cash_back`,`promotional_bonus` FROM `product` WHERE `id`='$row_temp_order[p_id]'";
 						if ($res_price = $connection->query($sql_price)) {
 							//Price From Product Table
 							$row_price = $res_price->fetch_assoc();
 							$price_product = $row_price['price'];
							$single_price = floatval($price_product) * $row_temp_order['quantity'];

							$single_cgst = floatval($row_price['cgst']) * $row_temp_order['quantity'];
							$single_sgst = floatval($row_price['sgst']) * $row_temp_order['quantity'];							
							$single_cashback = floatval($row_price['cash_back']) * $row_temp_order['quantity'];
							$single_promotional_bonus = floatval($row_price['promotional_bonus']) * $row_temp_order['quantity'];

							$total_cgst = $total_cgst+$single_cgst;
							$total_sgst = $total_sgst+$single_sgst;
							$total_cashback = $total_cashback+$single_cashback;							
							$total_promotional_bonus = $total_promotional_bonus+$single_promotional_bonus;

 							$total_amount = floatval($total_amount) + ($single_price);

 							// if (($row_price['sub_cat_id'] != 22) && ($row_price['sub_cat_id'] != 23)) {
 							// 	$discountable_amount = floatval($discountable_amount) + $single_price;
 							// }

 							$order_details_sql = "INSERT INTO `order_details`(`id`, `user_id`, `order_id`, `p_id`, `price`, `quantity`,`sgst`,`cgst`,`total_sgst`,`total_cgst`,`total_cashback`,`total_amount`, `date`, `time`,`order_from`) VALUES (null,'$user_id','$order_id','$row_temp_order[p_id]','$price_product','$row_temp_order[quantity]','$row_price[cgst]','$row_price[sgst]','$single_sgst','$single_cgst','$single_cashback','$single_price','$date','$time','2')";
 							$stock = $row_price['stock'] - $row_temp_order['quantity'];
		 					if ($res_order_details = $connection->query($order_details_sql)) {
								$order_detail_id = $connection->insert_id;
		 						$sql_stock_update = "UPDATE `product` SET `stock` = '$stock' WHERE `id` = '$row_temp_order[p_id]'";
								 if ($res_stock_update = $connection->query($sql_stock_update)) {}
								 
								// Check star product if star add star list
								//all star_product List
								$check_star_sql = "SELECT * FROM `product` WHERE `id`='$row_temp_order[p_id]' AND `is_star_product` = '2'";
								if ($res_check_star = $connection->query($check_star_sql)) {
									if ($res_check_star->num_rows > 0) {
										starProductAdd($row_temp_order['p_id'],$order_detail_id,$user_id,$connection);
									}
								}
		 					}		 					
 						}

 					}

					/// After successfully insertion of order details Update Order with total amount
					$Payable_amount = $total_amount;
					$wallet_pay = 0;

 					// CHeck Order Amount is greater then 3000 or not if yes then apply discount
					// $discount = 0;
					// if ($discountable_amount >= 3000) {
					// 	$sql_discount = "SELECT `percentage` FROM `offer` WHERE `offer_type`='1'";
					// 	if ($res_discount = $connection->query($sql_discount)) {
					// 		$row_discount = $res_discount->fetch_assoc();
					// 		$data_discount = floatval($row_discount['percentage']);
					// 		$discount = ( $discountable_amount * floatval($data_discount)) / 100;
					// 		$Payable_amount = floatval($Payable_amount) - floatval($discount);
					// 	}
					// }
					
					/// If User Requests For Wallet Payment
					if ($wallet_status == 1) {

						$wallet_amount_sql = "SELECT * FROM `wallet` WHERE `user_id`='$user_id' AND `status` = '1'";
						if ($res_wallet_amount = $connection->query($wallet_amount_sql)) {

							if ($res_wallet_amount->num_rows > 0) {
							
								$wallet_amount_row = $res_wallet_amount->fetch_assoc();
								if ($wallet_amount_row['amount'] > $Payable_amount) {

									$wallet_amount = floatval($wallet_amount_row['amount']) - floatval($total_amount);
									$wallet_total_amount = floatval($wallet_amount_row['total_amount']) - floatval($total_amount);
									$sql_update_wallet = "UPDATE `wallet` SET `amount`='$wallet_amount',`total_amount`='$wallet_total_amount' WHERE `user_id` = '$user_id'";
									if ($res_wallet_update = $connection->query($sql_update_wallet)) {}

									$sql_wallet_history = "INSERT INTO `wallet_history`(`id`, `user_id`,`wallet_id`, `transaction_type`, `amount`,`total`, `comments`, `date`, `time`) VALUES (null,'$user_id','$wallet_amount_row[id]','1','$total_amount','$wallet_total_amount','Product Purchased Using Wallet','$date','$time')";
									if ($res_wallet_history = $connection->query($sql_wallet_history)) {}
									$wallet_pay = $total_amount;
									$Payable_amount = 0;

								}elseif($wallet_amount_row['amount'] > 0){
									$wallet_total_amount = floatval($wallet_amount_row['total_amount']) - floatval($wallet_amount_row['amount']);
									$sql_update_wallet = "UPDATE `wallet` SET `amount`='0',`total_amount`='$wallet_total_amount' WHERE `user_id` = '$user_id'";
									if ($res_wallet_update = $connection->query($sql_update_wallet)) {
										# code...
									}
									$sql_wallet_history = "INSERT INTO `wallet_history`(`id`, `user_id`, `wallet_id`, `transaction_type`, `amount`,`total`, `comments`, `date`, `time`) VALUES (null,'$user_id','$wallet_amount_row[id]','1','$wallet_amount_row[amount]','$wallet_total_amount','Product Purchased Using Wallet','$date','$time')";
									
									if ($res_wallet_history = $connection->query($sql_wallet_history)) {
										# code...
									}
									
									$Payable_amount = floatval($Payable_amount) - floatval($wallet_amount_row['amount']);

									$wallet_pay = $wallet_amount_row['amount'];

								
								}
							}
							

							$sql_update_order = "UPDATE `orders` SET `amount`='$total_amount',`wallet_pay`='$wallet_pay',`sgst` = '$total_sgst',`cgst` = '$total_cgst',`total`='$Payable_amount',`cashback`='$total_cashback' WHERE `id`='$order_id'";
							if ($res_order_update = $connection->query($sql_update_order)) {
								if (!empty($user_id) && ($total_cashback > 0 )) {
									cashbackCredit($user_id,$total_cashback,$connection);
								}

								if (!empty($user_row['parent_id'])) {
									promotionalCredit($user_row['parent_id'],$total_promotional_bonus,$connection);
								}

								$sql_cart_delete = "DELETE FROM `temp_invoice`";
								$connection->query($sql_cart_delete);
								if (isset($_SESSION['invoice_user'])) {
									unset($_SESSION['invoice_user']);
								}
								if (isset($_SESSION['is_wallet'])) {
									unset($_SESSION['is_wallet']);
								}
							}

						}
					}else{
						$sql_update_order = "UPDATE `orders` SET `amount`='$total_amount',`wallet_pay`='0',`sgst` = '$total_sgst',`cgst` = '$total_cgst',`total`='$Payable_amount',`cashback`='$total_cashback' WHERE `id`='$order_id'";
						if ($res_order_update = $connection->query($sql_update_order)) {
							if (!empty($user_id) && ($total_cashback > 0 )) {
								
								cashbackCredit($user_id,$total_cashback,$connection);
							}
							if (!empty($user_row['parent_id']) && ($total_promotional_bonus > 0 )) {
								promotionalCredit($user_row['parent_id'],$total_promotional_bonus,$connection);
							}

							$sql_cart_delete = "DELETE FROM `temp_invoice`";
							$connection->query($sql_cart_delete);
							if (isset($_SESSION['invoice_user'])) {
								unset($_SESSION['invoice_user']);
							}
							if (isset($_SESSION['is_wallet'])) {
								unset($_SESSION['is_wallet']);
							}
						}

					}

 					header("location:../../invoice_print.php?id=$order_id");
 					
 				}else{
 					header("location:../../make_invoice_form.php?msg=2");
 				}


 			}else{
 				header("location:../../make_invoice_form.php?msg=8");
 			}
 		}else{
 			header("location:../../make_invoice_form.php?msg=2");
 		}

 	
 	}else{
 		header("location:../../make_invoice_form.php?msg=2");
	 }
	 

	 function cashbackCredit($user_id,$amount,$connection){
	
		date_default_timezone_set('Asia/Kolkata');
		$date = date('Y-m-d');
		$time = date('H:i:s');

		$wallet_amount_sql = "SELECT * FROM `wallet` WHERE `user_id`='$user_id'";
		if ($res_wallet_amount = $connection->query($wallet_amount_sql)) {
			if ($res_wallet_amount->num_rows > 0) {
				$wallet_amount_row = $res_wallet_amount->fetch_assoc();
				$wallet_amount = $wallet_amount_row['current_cashback_amount']+$amount;
				$wallet_total_amount = floatval($wallet_amount) + floatval($wallet_amount_row['total_amount']);

				$sql_update_wallet = "UPDATE `wallet` SET `current_cashback_amount`='$wallet_amount',`total_amount`='$wallet_total_amount' WHERE `user_id` = '$user_id'";
				if ($res_wallet_update = $connection->query($sql_update_wallet)) {
					$sql_wallet_history = "INSERT INTO `wallet_history`(`id`, `user_id`,`wallet_id`, `transaction_type`, `amount`,`total`, `comments`, `date`, `time`) VALUES (null,'$user_id','$wallet_amount_row[id]','2','$amount','$wallet_total_amount','Product Purchased Cashback Credited','$date','$time')";
					if ($res_wallet_history = $connection->query($sql_wallet_history)) {}
				}
			}
		}
		return true;
	 }

	 function promotionalCredit($user_id,$amount,$connection){
		date_default_timezone_set('Asia/Kolkata');
		$date = date('Y-m-d');
		$time = date('H:i:s');

		$wallet_amount_sql = "SELECT * FROM `wallet` WHERE `user_id`='$user_id'";
		if ($res_wallet_amount = $connection->query($wallet_amount_sql)) {
			if ($res_wallet_amount->num_rows > 0) {
				$wallet_amount_row = $res_wallet_amount->fetch_assoc();
				$wallet_amount = $wallet_amount_row['amount']+$amount;
				$sql_update_wallet = "UPDATE `wallet` SET `amount`='$wallet_amount' WHERE `user_id` = '$user_id'";
				if ($res_wallet_update = $connection->query($sql_update_wallet)) {
					$sql_wallet_history = "INSERT INTO `wallet_history`(`id`, `user_id`,`wallet_id`, `transaction_type`, `amount`,`total`, `comments`, `date`, `time`) VALUES (null,'$user_id','$wallet_amount_row[id]','2','$amount','$wallet_amount','Promotional Bonus Credited Against Your Downline Purchase','$date','$time')";
					if ($res_wallet_history = $connection->query($sql_wallet_history)) {}
				}
			}
		}

		return true;
	 }

	 function starProductAdd($p_id,$order_detail_id,$user_id,$connection){
		date_default_timezone_set('Asia/Kolkata');
		$date = date('Y-m-d H:i:s');
		$month = date('m');
        $year = date('Y');
		$check_current_month_star_sql = "SELECT * FROM `orders_star` WHERE MONTH(created_at) = '$month' AND YEAR(created_at) = '$year' AND `p_id`='$p_id' AND `user_id`='$user_id'";
		if ($res_check_current_month_star = $connection->query($check_current_month_star_sql)) {
			if ($res_check_current_month_star->num_rows == 0) {				
				$star_sql = "INSERT INTO `orders_star`(`id`, `user_id`, `order_detail_id`, `p_id`, `created_at`) VALUES (null,'$user_id','$order_detail_id','$p_id','$date')";
				if ($res_star = $connection->query($star_sql)) {}
			}
		}
		
	 }

?>