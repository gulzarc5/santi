<?php

include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if (isset($_GET['id'])) {
    $package_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['id']));

    $sql_image_fetch = "SELECT * from `offer` where `id`='$package_id'";
    
    if ($res_image_fetch = $connection->query($sql_image_fetch)) {
        $row_image_fetch = $res_image_fetch->fetch_assoc();

        if (!empty($row_image_fetch['image'])) {
            unlink("uploads/package_image/$row_image_fetch[image]");
            unlink("uploads/package_image/thumb/$row_image_fetch[image]");
        }
    }



	$sql = "DELETE FROM `offer` WHERE `id` = '$package_id'";
	if ($res = $connection->query($sql)) {
		header("location:../../offer_form.php?msg=5");
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