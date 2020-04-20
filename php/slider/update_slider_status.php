<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if(isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['status'])){
    $id = $connection->real_escape_string(mysql_entities_fix_string($_GET['id']));
    $status = $connection->real_escape_string(mysql_entities_fix_string($_GET['status']));

    $sql = "UPDATE `slider` SET `status`='$status' WHERE `id`='$id'";
    if ($res = $connection->query($sql)) {
        header("location:../../slider_list.php?msg=1");
    }else{
        header("location:../../slider_list.php?msg=2");
    }
}else{
    header("location:../../slider_list.php?msg=2");
}




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>