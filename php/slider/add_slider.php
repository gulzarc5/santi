<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if(isset($_POST['submit'])){

    $image = $_FILES['image'];
    $title = $_POST['title'];
    $image_name = null;
    if (!empty($image['name'])) {

        $image_size = $image['size'];
        if ($image_size > 2097152 || $image_size < 2 ) {
                header("location:../../add_slider_form.php?msg=6");
                die();
        }

        $product_image_name   = $image['name'];
        $product_image_tmp_name = $image['tmp_name'];
        $ext_explode = explode(".",$product_image_name);
        $ext = strtolower(end($ext_explode));
        if( $ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='bmp' || $ext=='gif' ){
            $image_name = md5(uniqid()).date('y-m-d').".".$ext;
            $path = "../../uploads/slider_image/".$image_name ;
            $image_api_image_url ="uploads/slider_image/".$image_name ;
            move_uploaded_file($product_image_tmp_name,$path);

            include_once("../product/ak_php_img_lib_1.0.php");
            $thumb_path = "../../uploads/slider_image/thumb/".$image_name;
            $wmax = 350;
            $hmax = 300;
            ak_img_resize($path,$thumb_path, $wmax, $hmax, $ext);


            $sql = "INSERT INTO `slider`(`image`,`title`) VALUES ('$image_name','$title')";
            if ($result=$connection->query($sql)){
                header("location:../../add_slider_form.php?msg=1");
            }else{
                header("location:../../add_slider_form.php?msg=2");
            }
        }else{
            header("location:../../add_slider_form.php?msg=4");
            die();
        }
    }else{
        header("location:../../add_slider_form.php?msg=3");
            die();
    }
}else{
        header("location:../../add_slider_form.php?msg=2");
    }




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>