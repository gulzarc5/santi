<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if ($_POST['code']) {
	$code = $connection->real_escape_string(mysql_entities_fix_string($_POST['code']));
	 $numlength = strlen((string)$code);
    if($numlength > 12){
        $code = substr($code, 0, 12);
    }

	$sql = "SELECT * FROM `product` WHERE LEFT(`barcode`,12)='$code' AND `is_delete`!='2'";
	if ($res = $connection->query($sql)) {
		if ($res->num_rows > 0) {
			echo "2";
		}else{
			echo "1";
		}
	}else{
		echo "2";
	}
}else{
	echo "2";
}




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
	function mysql_fix_string($string){
	    if (get_magic_quotes_gpc()) 
	        $string = stripslashes($string);
	    return $string;
	}
?>