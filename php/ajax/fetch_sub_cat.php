<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if ($_POST['cat_id']) {
	$cat_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['cat_id']));

	$sql = "SELECT * FROM `sub_category` WHERE `category_id`='$cat_id'";
	if ($res = $connection->query($sql)) {
		$html = "<option value=''>Please Select Sub Category</option>";
		while($row = $res->fetch_assoc()){
			$html = $html."<option value='$row[id]'>$row[name]</option>";
		}
		echo $html;
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