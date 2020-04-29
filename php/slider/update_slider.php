<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if(isset($_POST['slider_id']) && !empty($_POST['slider_id'])){

    $image = $_FILES['image'];
    $title = $_POST['title'];
    $slider_id = $_POST['slider_id'];
    $image_name = null;
    if (!empty($image['name'])) {
        $image_size = $image['size'];
        if ($image_size > 2097152 || $image_size < 2 ) {
                header("location:../../edit_slider.php?msg=6&id=$slider_id");
                die();
        }

        $product_image_name   = $image['name'];
        $product_image_tmp_name = $image['tmp_name'];
        $ext_explode = explode(".",$product_image_name);
        $ext = strtolower(end($ext_explode));
        if( $ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='bmp' || $ext=='gif' ){
            $image_name = md5(uniqid()).date('now').".".$ext;
            $path = "../../uploads/slider_image/".$image_name ;
            $image_api_image_url ="uploads/slider_image/".$image_name ;
            move_uploaded_file($product_image_tmp_name,$path);

            include_once("../product/ak_php_img_lib_1.0.php");
            $thumb_path = "../../uploads/slider_image/thumb/".$image_name;
            $wmax = 350;
            $hmax = 300;
            ak_img_resize($path,$thumb_path, $wmax, $hmax, $ext);


            $sql = "UPDATE `slider` SET `image`='$image_name' WHERE `id`='$slider_id'";
            if ($result=$connection->query($sql)){}
        }else{
            header("location:../../edit_slider.php?msg=4&id=$slider_id");
            die();
        }
    }

    if (!empty($_POST['title'])) {
        $sql = "UPDATE `slider` SET `title`='$title'  WHERE `id`='$slider_id'";
        if ($result=$connection->query($sql)){}
    }

    header("location:../../edit_slider.php?msg=1&id=$slider_id");
}else{
    header("location:../../slider_list.php");
}




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>