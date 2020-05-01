<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";
date_default_timezone_set('Asia/Kolkata');

if ($_POST['submit']) {
	$name = $connection->real_escape_string(mysql_entities_fix_string($_POST['name']));
	$email = $connection->real_escape_string(mysql_entities_fix_string($_POST['email']));
	$mobile = $connection->real_escape_string(mysql_entities_fix_string($_POST['mobile']));
	$state = $connection->real_escape_string(mysql_entities_fix_string($_POST['state']));
	$city = $connection->real_escape_string(mysql_entities_fix_string($_POST['city']));
	$address = $connection->real_escape_string(mysql_entities_fix_string($_POST['address']));
	$pin = $_POST['pin'];


	$password = $connection->real_escape_string(mysql_entities_fix_string($mobile));
	$password = password_hash($password, PASSWORD_BCRYPT);

	$sql_check = "SELECT * FROM `users` WHERE `email`='$email'";
 	if ($res_check = $connection->query($sql_check)) {
 		if ($res_check->num_rows > 0) {
 			header("location:../../add_user_form.php?msg=3");
    		die();
 		} 			
	}

	$sql_check_mobile = "SELECT * FROM `users` WHERE `mobile`='$mobile'";
 	if ($res_check_mobile = $connection->query($sql_check_mobile)) {
 		if ($res_check_mobile->num_rows > 0) {
 			header("location:../../add_user_form.php?msg=4");
    		die();
 		} 			
	}
	$created_at = date('Y-m-d H:i:s');
	$sql = "INSERT INTO `users`(`id`, `parent_id`, `refferel`, `name`, `email`, `mobile`, `state`, `city`, `address`, `password`, `user_type`,`is_star`, `date`) VALUES (null,null,null,'$name','$email','$mobile','$state','$city','$address','$password','2','1','$created_at')";

	if ($res = $connection->query($sql)) {

		$user_id = $connection->insert_id;
 		$date = date('Y-m-d');
 		$time = date('h:i:s');
 		$sql_wallet = "INSERT INTO `wallet`(`id`, `user_id`, `amount`,`status`,`date`, `time`) VALUES (null,'$user_id','0','2','$date','$time')";
 		if ($res_wallet = $connection->query($sql_wallet)) {}

 		$sql_parmanent = "INSERT INTO `parmanent_address`(`id`, `user_id`, `state`, `city`, `location`, `pin`) VALUES (null,'$user_id','$state','$city','$address','$pin')";
 		if ($res_parmanent = $connection->query($sql_parmanent)) {}

 		$key = uniqid('api');
 	    $api_key_sql = "INSERT INTO `api_key`(`id`, `user_id`, `api_key`, `date`) VALUES (null,'$user_id','$key','$created_at')";
		if ($connection->query($api_key_sql)) {
			$data_user = [
				'user_id' => $user_id,
				'api_key'=> $key,
				'name' => $name,
				'email' => $email,
				'mobile' => $mobile,
			];
		}

		header("location:../../add_user_form.php?msg=1");
    	die();
	}else{
		header("location:../../add_user_form.php?msg=2");
    	die();
	}
}else{
	header("location:../../add_user_form.php?msg=2");
    	die();
}




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>