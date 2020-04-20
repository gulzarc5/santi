<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if ($_POST['submit']) {
	$p_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['p_id']));
	$stock = $connection->real_escape_string(mysql_entities_fix_string($_POST['stock']));

	$sql = "SELECT stock FROM `product` WHERE `id`='$p_id'";
	if ($res = $connection->query($sql)) {
		$row = $res->fetch_assoc();
		$new_stock = $stock + intval($row['stock']);

		$sql_update = "UPDATE `product` SET `stock`='$new_stock' WHERE `id`='$p_id'";
		if ($res_update = $connection->query($sql_update)) {
	 		
			header("location:../../add_stock_form.php?msg=1&p_id=$p_id");
		}
	}else{
		header("location:../../add_stock_form.php?msg=2&p_id=$p_id");
	}
}


function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>