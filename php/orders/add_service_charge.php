<?php

include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if ($_POST['submit']) {
		$o_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['id']));
		$amount = $connection->real_escape_string(mysql_entities_fix_string($_POST['amount']));
		
		$sql_update = "UPDATE `orders` SET  `service_charge`= '$amount' WHERE `id`='$o_id'";
		$res = $connection->query($sql_update);
		
		if($res){
			header("location:../../view_orders.php?id=$o_id");
		}else{
			header("location:./../../service_charge_form.php?id=$o_id&msg=3");
		}
	
	}



function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>