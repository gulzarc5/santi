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
	$pin = $connection->real_escape_string(mysql_entities_fix_string($_POST['pin'] ));
	$mobile = $connection->real_escape_string(mysql_entities_fix_string($_POST['mobile'] ));
	
	

	$user_fetch_sql = "SELECT * FROM `users` WHERE `email`='$email'";
	if ($user_fetch_res = $connection->query($user_fetch_sql)) {
		if ($user_fetch_res->num_rows > 0 ) {
			$user_fetch_row = $user_fetch_res->fetch_assoc();
			if ($user_fetch_row['id'] != $user_id) {
				header("location:../../edit_user.php?msg=1&u_id=".$user_id."");
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
 			        header("location:../../edit_user.php?msg=3&u_id=".$user_id."");
    			    die();
 			    }
 				
 			} 			
	 	}
	}

	$sql = "UPDATE `users` SET `name`='$name',`email`='$email',`mobile`='$mobile' WHERE `id` = '$user_id'";

	if ($res = $connection->query($sql)) {

		$addr_row_count = 0;
		$sql_addr_count = "SELECT * FROM `parmanent_address` WHERE `user_id`='$user_id'";
		if ($res_addr_count = $connection->query($sql_addr_count)) {
			$addr_row_count = $res_addr_count->num_rows;
		}

		if ($addr_row_count > 0) {
			$sql_addr = "UPDATE `parmanent_address` SET `state`='$state',`city`='$city',`location`='$address',`pin`='$pin' WHERE `user_id`='$user_id'";
			if ($res_addr = $connection->query($sql_addr)) {
				header("location:../../user_list.php?msg=1");
	    		die();
			}else{
				header("location:../../edit_user.php?msg=2&u_id=".$user_id."");
	    		die();
			}
		}else{
			$sql_addr = "INSERT INTO `parmanent_address`(`id`, `user_id`, `state`, `city`, `location`, `pin`) VALUES (null,'$user_id','$state','$city','$address','$pin')";
			if ($res_addr = $connection->query($sql_addr)) {
				header("location:../../user_list.php?msg=1");
	    		die();
			}else{
				header("location:../../edit_user.php?msg=2&u_id=".$user_id."");
	    		die();
			}
		}		
		
	}else{
		header("location:../../edit_user.php?msg=2&u_id=".$user_id."");
    	die();
	}
}else{
	header("location:../../edit_user.php?msg=2&u_id=".$user_id."");
    	die();
}




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>