<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if (isset($_GET['u_id'])) {
	$user_id = $connection->real_escape_string(mysql_entities_fix_string($_GET['u_id'] ));
	$password = password_hash(123456, PASSWORD_BCRYPT);
	$sql = "UPDATE `users` SET `password`='$password' WHERE `id`='$user_id'";
	// print_r($sql);
	// die();
	if ($res = $connection->query($sql)) {

		header("location:../../employee_list.php?msg=9");
		
	}
}



function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>