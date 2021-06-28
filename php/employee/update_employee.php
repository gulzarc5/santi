<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if ($_POST['submit']) {
	$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id']));
	$name = $connection->real_escape_string(mysql_entities_fix_string($_POST['name'] ));
	$email = $connection->real_escape_string(mysql_entities_fix_string($_POST['email'] ));
	$state = $connection->real_escape_string(mysql_entities_fix_string($_POST['state'] ));
	$city = $connection->real_escape_string(mysql_entities_fix_string($_POST['city'] ));
	$address = $connection->real_escape_string(mysql_entities_fix_string($_POST['address']));
	$mobile = $connection->real_escape_string(mysql_entities_fix_string($_POST['mobile'] ));
	
	

	$user_fetch_sql = "SELECT * FROM `users` WHERE `email`='$email'";
	if ($user_fetch_res = $connection->query($user_fetch_sql)) {
		if ($user_fetch_res->num_rows > 0 ) {
			$user_fetch_row = $user_fetch_res->fetch_assoc();
			if ($user_fetch_row['id'] != $user_id) {
				header("location:../../employee_edit_form.php?msg=1&u_id=".$user_id."");
    			die();
			}			
		}
	}

	if (!empty($mobile)) {
		$sql_check_mobile = "SELECT * FROM `users` WHERE `mobile`='$mobile'";
 		if ($res_check_mobile = $connection->query($sql_check_mobile)) {
 			if ($res_check_mobile->num_rows > 0) {
 			    $user_fetch_mobile = $res_check_mobile->fetch_assoc();
 			    if($user_fetch_mobile['id'] != $user_id){
 			        header("location:../../employee_edit_form.php?msg=3&u_id=".$user_id."");
    			    die();
 			    }
 				
 			} 			
	 	}
	}

	$sql = "UPDATE `users` SET `state`='$state', `city`='$city', `address`='$address', `name`='$name',`email`='$email',`mobile`='$mobile' WHERE `id` = '$user_id'";

	if ($res = $connection->query($sql)) {



		header("location:../../employee_list.php?msg=1");
		die();		
		
	}else{
		header("location:../../employee_edit_form.php?msg=2&u_id=".$user_id."");
    	die();
	}
}else{
	header("location:../../employee_edit_form.php?msg=2&u_id=".$user_id."");
    	die();
}




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>