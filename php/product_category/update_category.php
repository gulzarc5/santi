<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if(isset($_POST['category']) && !empty($_POST['sub_category'])){
	$category = $connection->real_escape_string(mysql_entities_fix_string($_POST['category']));
    $sub_category = $connection->real_escape_string(mysql_entities_fix_string($_POST['sub_category']));
    $sub_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['sub_id']));
    //echo $category;
   $sql = "UPDATE `sub_category` SET `name`='$sub_category',`category_id`='$category' WHERE `id`='$sub_id'";
    if ($result=$connection->query($sql)){
    
		header("location:../../edit_cat.php?sub_id=1&msg=1");
	}else{
        header("location:../../edit_cat.php?sub_id=$sub_id&msg=2");
    }
}else{
        header("location:../../edit_cat.php?sub_id=$sub_id&msg=2");
    }




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>