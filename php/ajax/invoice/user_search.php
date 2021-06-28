<?php
// include "../admin_login_system/php_user_session_check.php";
session_start();
include "../../database/connection.php";
header("content-type: application/json");

if (isset($_POST['search_key']) && !empty($_POST['search_key'])) {
	$search_key = $_POST['search_key'];
	if(is_numeric($search_key)){
		$sql = "SELECT `users`.*,`wallet`.`total_amount` as `amount` FROM `users` INNER JOIN `wallet` ON `wallet`.`user_id` = `users`.`id` WHERE `users`.`mobile` = '$search_key'";
	}else{
		$sql = "SELECT `users`.*,`wallet`.`total_amount` as `amount` FROM `users` INNER JOIN `wallet` ON `wallet`.`user_id` = `users`.`id` WHERE `users`.`email` = '$search_key'";
	}
    $prev_bal = 0;
	if ($res_sql = $connection->query($sql)) {
		if ($res_sql->num_rows > 0) {
			$row = $res_sql->fetch_assoc();
			$sql_prev_bal = "SELECT `amount` FROM `user_credit` WHERE `user_id`='$row[id]'";
			if ($res_prev_bal = $connection->query($sql_prev_bal)) {
				if ($res_prev_bal->num_rows > 0) {
					$row_prev_bal = $res_prev_bal->fetch_assoc();
					$prev_bal = $row_prev_bal['amount'];
				}
			}
			$html =   '<h4>User Info &nbsp';
			if ($row['is_regular'] == '2') {
				$html.="<label class='label label-success'>Regular Customer</label>";
			  }
			$html.='</h4><div class="col-md-6">     
	                <b>Name : </b> '.$row['name'].'
	              </div>
	              <div class="col-md-6">     
	                <b>Mobile : </b> '.$row['mobile'].'
	                </div>      
	              <div class="col-md-6">     
	                <b>Is Free Shopping Amount: </b> '.$row['amount'].' 
				  </div>
				  <div class="col-md-6">     
	                <b>Previous Balance: </b> '.$prev_bal.' 
				  </div>';
			$data = [
				'data' => $html,
				'status' => 1,
			];
			echo json_encode($data);
			
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