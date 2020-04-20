<?php

include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if (isset($_POST['offer_id'])) {
	$offer_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['offer_id']));
	$name = $connection->real_escape_string(mysql_entities_fix_string($_POST['name']));
	$percentage = $connection->real_escape_string(mysql_entities_fix_string($_POST['percentage']));

	$sql = "UPDATE `offer` SET `name`='$name', `percentage`='$percentage' WHERE `id`='$offer_id'";
	if ($res = $connection->query($sql)) {
		header("location:../../user_offer_edit.php?msg=1&id=$offer_id");
         die();
	}else{
		 header("location:../../user_offer_edit.php?msg=2&id=$offer_id");
         die();
	}
}else{
	 header("location:../../user_offer_edit.php?msg=2&id=$offer_id");
     die();
}




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>