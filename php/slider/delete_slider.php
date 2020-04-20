<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if(isset($_GET['id']) && !empty($_GET['id'])){
    $id = $connection->real_escape_string(mysql_entities_fix_string($_GET['id']));
    $sql_fetch_slider = "SELECT * FROM `slider` WHERE `id`='$id'";
    if ($res_fetch_slider = $connection->query($sql_fetch_slider)) {
        $row_fetch_slider = $res_fetch_slider->fetch_assoc();
        $image_name = $row_fetch_slider['image'];
        unlink("../../uploads/slider_image/thumb/$image_name");
        unlink("../../uploads/slider_image/$image_name");

         $sql = "DELETE FROM `slider` WHERE `id`='$id'";
        if ($res = $connection->query($sql)) {
            header("location:../../slider_list.php?msg=1");
        }else{
            header("location:../../slider_list.php?msg=21");
        }
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