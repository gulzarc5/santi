<?php
	include 'php/database/connection.php';
	// include 'php/admin_login_system/page_user_session_check.php';

	date_default_timezone_set('Asia/Kolkata'); 
	$monthYear = date('Y-m');
	
	$start_date = $monthYear."-01";
	$end_date = $monthYear."-30";
	echo "Start Date = $start_date   And End Date  $end_date<br>";
	// FetchStar min purchase order
	$star_min_purchase = null;

	$min_star_purchase = "SELECT * FROM `star_pro_min_purchase_limit` WHERE `id`='1'";
    if ($res_package = $connection->query($min_star_purchase)) {
      $row_star = $res_package->fetch_assoc();
      $star_min_purchase = $row_star['purchase_limit'];
  	}


  	// Disable All Users Wallet And User Star
	$users_disable_star = "UPDATE `users` SET `is_star`='1' WHERE `user_type`='2'";
	if ($res_disable_star = $connection->query($users_disable_star)) {

		$wallet_disable = "UPDATE `wallet` SET `status`='2'";
		if ($res_wallet_disable =  $connection->query($wallet_disable)) {			
			$users_sql = "SELECT * FROM `users` WHERE `status`='1' AND `user_type`='2'";
			if ($res_user = $connection->query($users_sql)) {
				/*check user star product purchase >= $star_min_purchase
					if Yes then active user wallet Active user star
				*/
				while ($row_user = $res_user->fetch_assoc()) {
					$star_count = fetchStarProduct($row_user['id'],$connection);

					if ($star_min_purchase <= $star_count) {
						// Active User for star member and Active user wallet
						activeUserStar($row_user['id'],$connection);
						echo "Star Member = $row_user[id] AND Star Purchase $star_count<br>";
					}else{
						deActiveUserStar($row_user['id'],$connection);
						echo "No Star = $row_user[id] AND Star Purchase $star_count<br>";
					}
				}				
			}			
		}
	}


	// Function to fetch users star orders
	function fetchStarProduct($user_id,$connection)
	{
		$total_star_product = 0;
		$star_product_sql = "SELECT * FROM `orders_star` WHERE `user_id` = '$user_id'";
		if ($res_star_product = $connection->query($star_product_sql)) {
			$total_star_product = $res_star_product->num_rows;
		}
		return $total_star_product;
	}
	
	// Function to Active User for star member and Active user wallet
	function activeUserStar($user_id,$connection)
	{
		$user_star_active_sql = "UPDATE `users` SET `is_star`='2' WHERE `id`='$user_id'";
		if ($res_user_star_active = $connection->query($user_star_active_sql)) {

			$user_wallet_active = "UPDATE `wallet` SET `status`='1' WHERE `user_id`='$user_id'";
			if ($res_user_wallet_active =  $connection->query($user_wallet_active)) {}
		}
		return true;
	}

	// Function to Active User for star member and Active user wallet
	function deActiveUserStar($user_id,$connection)
	{
		$user_star_active_sql = "UPDATE `users` SET `is_star`='1' WHERE `id`='$user_id'";
		if ($res_user_star_active = $connection->query($user_star_active_sql)) {

			$user_wallet_active = "UPDATE `wallet` SET `status`='2' WHERE `user_id`='$user_id'";
			if ($res_user_wallet_active =  $connection->query($user_wallet_active)) {}
		}
		return true;
	}
?>