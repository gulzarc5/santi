<?php
	include 'php/database/connection.php';
	// include 'php/admin_login_system/page_user_session_check.php';

	date_default_timezone_set('Asia/Kolkata'); 
	$year = date('Y');
	$month = date('m');
	
	echo "Start Date = $year   And End Date  $month<br>";
	if (!isset($_GET['page'])) {
		$star_scan_chk = "SELECT * FROM `star_member_scan` WHERE WHERE YEAR(`date`) = '$year' AND MONTH(`date`) = '$month'";
		if($res_scan_chk = $connection->query($star_scan_chk)){
			if($res_scan_chk->num_rows > 0){
				echo "scan success already done";
				die();
			}
		}
	}
	
	// FetchStar min purchase order
	$star_min_purchase = null;

	$min_star_purchase = "SELECT * FROM `star_pro_min_purchase_limit` WHERE `id`='1'";
    if ($res_package = $connection->query($min_star_purchase)) {
      $row_star = $res_package->fetch_assoc();
      $star_min_purchase = $row_star['purchase_limit'];
  	}else{
		echo "something Went Wrong";
		die();
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
				$total_star_member = 0;
				while ($row_user = $res_user->fetch_assoc()) {					
					$data = addCurrentWalletBalanceToPrev($row_user['id'],$connection);
					$star_count = fetchStarProduct($row_user['id'],$year,$month,$connection);
					if ($star_min_purchase <= $star_count) {
						// Active User for star member and Active user wallet
						activeUserStar($row_user['id'],$connection);
						$total_star_member++;
						echo "Star Member = $row_user[id] AND Star Purchase $star_count<br>";
					}else{
						deActiveUserStar($row_user['id'],$connection);
						echo "No Star = $row_user[id] AND Star Purchase $star_count<br>";
					}
				}
				$scan_date = date('Y-m-d');
				$sql_update_star_scan = "INSERT INTO `star_member_scan`(`date`, `total_star_member`) VALUES ('$scan_date','$total_star_member')";
				if ($res_star_scan = $connection->query($sql_update_star_scan)) {
					# code...
				}
			}			
		}else{
			echo "something Went Wrong";
			die();
		}	
	}else{
		echo "something Went Wrong";
		die();
	}


	// Function to fetch users star orders
	function fetchStarProduct($user_id,$year,$month,$connection)
	{
		$total_star_product = 0;
		$star_product_sql = "SELECT * FROM `orders_star` WHERE `user_id` = '$user_id' AND YEAR(created_at) = '$year' AND MONTH(created_at) = '$month'";
		// echo $star_product_sql."<br>";
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

	// Function to Current wallet balance sent to prev
	function addCurrentWalletBalanceToPrev($user_id,$connection)
	{
		$user_star_active_sql = "UPDATE `wallet` SET `amount`=(`amount`+`current_cashback_amount`),`current_cashback_amount`='0' WHERE `user_id`='$user_id'";
		if ($res_user_star_active = $connection->query($user_star_active_sql)) {
		}
		return true;
	}
?>