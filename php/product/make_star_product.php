<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if (isset($_GET['p_id']) && !empty($_GET['p_id'])) {
	$p_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['p_id']));
	date_default_timezone_set('Asia/Kolkata');
	$date = date('Y-m-d');
	$sql = "UPDATE `product` SET `is_star_product`='2', `star_added_date` = '$date' WHERE `id`='$p_id'";
	if ($res = $connection->query($sql)) {
		header("location:../../education.php?msg=1");
	}else{
		header("location:../../education.php?msg=2");
	}
}


function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>