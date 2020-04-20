<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if(isset($_POST['category']) && !empty($_POST['sub_category'])){
	$category = $connection->real_escape_string(mysql_entities_fix_string($_POST['category']));
    $sub_category = $connection->real_escape_string(mysql_entities_fix_string($_POST['sub_category']));
    //echo $category;
   
    $sql ="INSERT INTO `sub_category`(`id`, `name`, `category_id`) VALUES (null,'$sub_category','$category')";
    if ($result=$connection->query($sql)){
    
		header("location:../../add_category_form.php?msg=1");
	}else{
        header("location:../../add_category_form.php?msg=2");
    }
}else{
        header("location:../../add_category_form.php?msg=3");
    }




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>