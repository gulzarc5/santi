<?php

include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if ($_POST['submit']) {
	$u_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['u_id']));
	$amount = $connection->real_escape_string(mysql_entities_fix_string($_POST['amount']));

	$sql = "SELECT * FROM `user_credit` WHERE `user_id`='$u_id'";
	if ($res = $connection->query($sql)) {
		$row = $res->fetch_assoc();
		date_default_timezone_set('Asia/Kolkata');
 		$date = date('Y-m-d');
	 	$time = date('H:i:s');
	
		$total_amount = floatval($row['amount'])-$amount;
        if($total_amount <0){
            $total_amount = 0;
        }
		$sql_update = "UPDATE `user_credit` SET  `amount`= '$total_amount' WHERE `id`='$row[id]'";
		if ($res_update = $connection->query($sql_update)) {

			$sql_credit_details = "INSERT INTO `user_credit_details` (`id`, `user_id`,`credit_id`, `amount`,`total_amount`, `type`, `comment`, `date`) VALUES (null,'$u_id','$row[id]','$amount','$total_amount','2','Credit Balance paid','$date')";
           
            if ($res_credit_details = $connection->query($sql_credit_details)) {}

			header("location:../../receive_credit_form.php?msg=1&u_id=$u_id");
		}
	}else{
		header("location:../../receive_credit_form.php?msg=2&u_id=$u_id");
	}
}


function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>