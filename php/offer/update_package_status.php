<?php

include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if (isset($_GET['id']) && isset($_GET['status'])) {
    $offer_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['id']));
	$status = $connection->real_escape_string(mysql_entities_fix_string($_GET['status']));


	$sql = "UPDATE `offer` SET `status`='$status' WHERE `id` = '$offer_id'";
    // echo $sql;
    // die();
	if ($res = $connection->query($sql)) {
		header("location:../../offer_form.php?msg=6");
         die();
	}else{
		 header("location:../../offer_form.php?msg=2");
         die();
	}
}else{
	 header("location:../../offer_form.php?msg=2");
     die();
}




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>