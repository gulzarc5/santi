<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if (isset($_GET['user_id']) && isset($_GET['status']) && isset($_GET['page'])) {
	$user_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['user_id'] ));
	$status = $connection->real_escape_string(mysql_entities_fix_string($_GET['status'] ));
	$page = $_GET['page'];
	$sql = "UPDATE `users` SET `status`='$status' WHERE `id`='$user_id'";
	if ($res = $connection->query($sql)) {
		if ($page == 1) {
			header("location:../../deactivated_user_list.php");
		}else{
			header("location:../../user_list.php");
		}
		
	}
}



function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>