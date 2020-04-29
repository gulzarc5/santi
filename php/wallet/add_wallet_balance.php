<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if ($_POST['submit']) {
	$u_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['u_id']));
	$amount = $connection->real_escape_string(mysql_entities_fix_string($_POST['amount']));

	$sql = "SELECT * FROM `wallet` WHERE `user_id`='$u_id'";
	if ($res = $connection->query($sql)) {
		$row = $res->fetch_assoc();
		date_default_timezone_set('Asia/Kolkata');
 		$date = date('Y-m-d');
	 	$time = date('H:i:s');
		$new_amount = $amount + floatval($row['amount']);
		$total_amount = $amount + floatval($row['total_amount']);

		$sql_update = "UPDATE `wallet` SET `amount`='$new_amount', `total_amount`= '$total_amount' WHERE `id`='$row[id]'";
		if ($res_update = $connection->query($sql_update)) {

			$sql_wallet_history = "INSERT INTO `wallet_history`(`id`, `user_id`,`wallet_id`, `transaction_type`, `amount`,`total`, `comments`, `date`, `time`) VALUES (null,'$u_id','$row[id]','2','$amount','$total_amount','Balance Creditrd By Shantirekha','$date','$time')";
	 		if ($res_wallet_history = $connection->query($sql_wallet_history)) {}

			header("location:../../add_wallet_form.php?msg=1&u_id=$u_id");
		}
	}else{
		header("location:../../add_wallet_form.php?msg=2&u_id=$u_id");
	}
}


function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>