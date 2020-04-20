<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if (isset($_GET['u_id']) && isset($_GET['status'])) {
	
	$u_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['u_id']));
	$status = $connection->real_escape_string(mysql_entities_fix_string($_GET['status']));

	$sql = "UPDATE `users` SET `status`='$status' WHERE `id`='$u_id'";
	if ($res = $connection->query($sql)) {
		if ($status == 2) {
			header("location:../../deactivated_user_list.php");
    		die();
		}else{
			header("location:../../user_list.php");
    		die();
		}		
	}else{
		if ($status == 2) {
			header("location:../../deactivated_user_list.php");
    		die();
		}else{
			header("location:../../user_list.php");
    		die();
		}	
	}

}

function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}