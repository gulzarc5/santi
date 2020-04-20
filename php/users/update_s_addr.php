<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if ($_POST['submit']) {
	$s_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['s_id']));
	$email = $connection->real_escape_string(mysql_entities_fix_string($_POST['email'] ));
	$user_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['user_id'] ));
	$state = $connection->real_escape_string(mysql_entities_fix_string($_POST['state'] ));
	$city = $connection->real_escape_string(mysql_entities_fix_string($_POST['city'] ));
	$address = $connection->real_escape_string(mysql_entities_fix_string($_POST['address']));
	$pin = $connection->real_escape_string(mysql_entities_fix_string($_POST['pin'] ));
	$mobile = $connection->real_escape_string(mysql_entities_fix_string($_POST['mobile'] ));
	
	


	

	$sql = "UPDATE `shipping_address` SET `state`='$state',`city`='$city',`location`='$address',`mobile`='$mobile',`email`='$email',`pin`='$pin' WHERE `id`='$s_id'";

	if ($res = $connection->query($sql)) {

		header("location:../../user_view.php?u_id=".$user_id."");
    	die();		
		
	}else{
		header("location:../../user_view.php?u_id=".$user_id."");
    	die();	
	}
}else{
	header("location:../../user_view.php?u_id=".$user_id."");
    	die();	
}




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>