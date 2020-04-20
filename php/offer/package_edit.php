<?php

include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if (isset($_POST['package_add'])) {
    $package_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['package_id']));
	$name = $connection->real_escape_string(mysql_entities_fix_string($_POST['name']));
	$description = $connection->real_escape_string(mysql_entities_fix_string($_POST['description']));
	$start_offer = $connection->real_escape_string(mysql_entities_fix_string($_POST['start_offer']));
	$percentage = $connection->real_escape_string(mysql_entities_fix_string($_POST['percentage']));



	



	$sql = "UPDATE `offer` SET `name`='$name', `description` = '$description', `offer_start` = '$start_offer', `percentage` = '$percentage' WHERE `id` = '$package_id'";
	if ($res = $connection->query($sql)) {
		header("location:../../offer_form.php?msg=1");
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