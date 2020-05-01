<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";
date_default_timezone_set('Asia/Kolkata');

if ($_POST['product_id'] && $_POST['size']) {
	$product_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['product_id']));
	$size_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['size'] ));
	$buy = $connection->real_escape_string(mysql_entities_fix_string($_POST['buy'] ));
	$offer = $connection->real_escape_string(mysql_entities_fix_string($_POST['offer'] ));
	$offer_type = $connection->real_escape_string(mysql_entities_fix_string($_POST['offer_type'] ));
	$date = date('Y-m-d H:i:s');
	$sql = "INSERT INTO `offer`(`id`, `product_id`, `size_id`, `sale`, `offer`, `offer_type`, `created_at`) VALUES (null,'$product_id','$size_id','$buy','$offer','$offer_type','$date')";

	if ($res = $connection->query($sql)) {
		// echo "inserted";
		header("location:../../product_list.php?msg=5");
    	die();
	}else{
		header("location:../../product_list.php?msg=2");
    	die();
	}
}else{
	header("location:../../product_list.php?msg=2");
    	die();
}




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>