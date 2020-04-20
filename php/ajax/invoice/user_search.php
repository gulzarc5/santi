<?php
// include "../admin_login_system/php_user_session_check.php";
session_start();
include "../../database/connection.php";
header("content-type: application/json");

if (isset($_POST['search_key']) && !empty($_POST['search_key'])) {
	$search_key = $_POST['search_key'];
	if(is_numeric($search_key)){
		$sql = "SELECT * FROM `users` WHERE `mobile` = '$search_key'";
	}else{
		$sql = "SELECT * FROM `users` WHERE `email` = '$search_key'";
	}

	if ($res_sql = $connection->query($sql)) {
		if ($res_sql->num_rows > 0) {
			$row = $res_sql->fetch_assoc();
			if ($row['status'] == '1') {
				if ($row['is_star'] == '1') {
					$html = '<h4>User Info</h4>
	              <div class="col-md-6">     
	                <b>Name : </b> '.$row['name'].'
	              </div>
	              <div class="col-md-6">     
	                <b>Mobile : </b> '.$row['mobile'].'
	                </div>      
	              <div class="col-md-6">     
	                <b>Is Star : </b> No 
	              </div> ';
	              $data = [
	              	'status' => 1,
	              	'html' => $html,
	              ];
	              echo json_encode($data);
				} else {
					$sql_wallet = "SELECT * FROM `wallet` WHERE `user_id`='$row[id]'";
					$balance = 0;
					if ($res_wallet = $connection->query($sql_wallet)) {
						$row_wallet = $res_wallet->fetch_assoc();
						$balance = $row_wallet['amount'];
					}
					$html =   '<h4>User Info</h4>
	              <div class="col-md-6">     
	                <b>Name : </b> '.$row['name'].'
	              </div>
	              <div class="col-md-6">     
	                <b>Mobile : </b> '.$row['mobile'].'
	                </div>      
	              <div class="col-md-6">     
	                <b>Is Star : </b> Yes 
	              </div> 
	              <div class="col-md-6">                
	                <b>Wallet : </b> '.$balance.'
	              </div>';
	              $status = 1;
	              if ($balance > 0) {
	              	$status = 2;
	              }
	               $data = [
	              	'status' => $status,
	              	'html' => $html,
	              ];
	              echo json_encode($data);
				}			
				
			} else {
				echo "4";
			}
			
		}else{
			echo "3";
		}
	}else{
		echo "2";
	}
}else{
	echo "2";
}



?>