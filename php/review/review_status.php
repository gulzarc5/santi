<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if (!empty($_GET['r_id']) && !empty($_GET['status'])) {
	$r_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['r_id']));
	$status = $connection->real_escape_string(mysql_entities_fix_string($_GET['status']));
	$sql = "UPDATE `customer_review` SET `status`='$status' WHERE `id`='$r_id'";
	
	if ($res = $connection->query($sql)) {
		header("location:../../customer_review.php?msg=1");
	}else{
		header("location:../../customer_review.php?msg=2");
	}
}else{
	header("location:../../customer_review.php?msg=3");
}


function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>