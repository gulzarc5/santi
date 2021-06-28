<?php

include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if (isset($_POST['star']) && !empty($_POST['star'])) {
	$limit = $connection->real_escape_string(mysql_entities_fix_string($_POST['star_input']));

	$sql = "UPDATE `star_pro_min_purchase_limit` SET `purchase_limit`='$limit' WHERE `id`='1'";
	if ($res = $connection->query($sql)) {
		header("location:../../offer_form.php");
         die();
	}else{
		 header("location:../../offer_form.php");
         die();
	}
}else{
	 header("location:../../offer_form.php");
     die();
}

function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>