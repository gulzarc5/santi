<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if(isset($_POST['category']) && !empty($_POST['sub_category'])){
	$category = $connection->real_escape_string(mysql_entities_fix_string($_POST['category']));
    $sub_category = $connection->real_escape_string(mysql_entities_fix_string($_POST['sub_category']));
    $sub_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['sub_id']));
    //echo $category;

    $image = $_FILES['image'];
    $image_name = null;
    if (!empty($image['name'])) {
        $image_size = $image['size'];
        if ($image_size > 2097152 || $image_size < 2 ) {
                header("location:../../edit_cat.php?msg=6&sub_id=$sub_id");
                die();
        }

        $category_image_name   = $image['name'];
        $category_image_tmp_name = $image['tmp_name'];
        $ext_explode = explode(".",$category_image_name);
        $ext = strtolower(end($ext_explode));
        if( $ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='bmp' || $ext=='gif' ){
            $image_name = md5(uniqid()).date('y-m-d').".".$ext;
            $path = "../../uploads/sub_category/".$image_name ;
            move_uploaded_file($category_image_tmp_name,$path);

            include_once("../product/ak_php_img_lib_1.0.php");
            $thumb_path = "../../uploads/sub_category/thumb/".$image_name;
            $wmax = 600;
            $hmax = 600;
            ak_img_resize($path,$thumb_path, $wmax, $hmax, $ext);

            $main_image_name = null;
            $sql_main_image = "SELECT `image` FROM `sub_category` WHERE `id`='$sub_id'";
            if ($res_main_image = $connection->query($sql_main_image)) {
               $row_main_image = $res_main_image->fetch_assoc();
               $main_image_name = $row_main_image['image'];
            }

            $sql = "UPDATE `sub_category` SET `image`='$image_name' WHERE `id`='$sub_id'";
            if ($result=$connection->query($sql)){
                if (!empty($main_image_name)) {
                    $main_path = "../../uploads/sub_category/".$main_image_name ;
                    if (file_exists($main_path)) {
                        unlink($main_path);
                    }

                    $main_thumb_path = "../../uploads/sub_category/thumb/".$main_image_name ;
                    if (file_exists($main_thumb_path)) {
                        unlink($main_thumb_path);
                    }
                }
            }
        }else{
            header("location:../../edit_cat.php?msg=4&sub_id=$sub_id");
            die();
        }
    }


   $sql = "UPDATE `sub_category` SET `name`='$sub_category',`category_id`='$category' WHERE `id`='$sub_id'";
    if ($result=$connection->query($sql)){
    
		header("location:../../edit_cat.php?sub_id=$sub_id&msg=1");
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