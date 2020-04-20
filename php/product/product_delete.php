<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if (isset($_GET['p_id'])) {
	$product_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['p_id'] ));
	$sql = "UPDATE `product` SET `is_delete`='2' WHERE `id`='$product_id'";
	if ($res = $connection->query($sql)) {
		header("location:../../education.php?msg=1");
    	die();
	}else{
	    header("location:../../education.php?msg=2");
    	die();
	}
}else{
	header("location:../../education.php?msg=3");
    	die();
}



function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>