<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";

if(isset($_POST['category']) ){
	$category = $connection->real_escape_string(mysql_entities_fix_string($_POST['category']));
    //echo $category;
    $image = $_FILES['image'];
    $image_name = null;
    if (!empty($image['name'])) {
        $image_size = $image['size'];
        if ($image_size > 2097152 || $image_size < 2 ) {
                header("location:../../add_main_category_form.php?msg=6");
                die();
        }

        $category_image_name   = $image['name'];
        $category_image_tmp_name = $image['tmp_name'];
        $ext_explode = explode(".",$category_image_name);
        $ext = strtolower(end($ext_explode));
        if( $ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='bmp' || $ext=='gif' ){
            $image_name = md5(uniqid()).date('y-m-d').".".$ext;
            $path = "../../uploads/main_category/".$image_name ;
            move_uploaded_file($category_image_tmp_name,$path);

            include_once("../product/ak_php_img_lib_1.0.php");
            $thumb_path = "../../uploads/main_category/thumb/".$image_name;
            $wmax = 600;
            $hmax = 600;
            ak_img_resize($path,$thumb_path, $wmax, $hmax, $ext);

        }else{
            header("location:../../add_main_category_form.php?msg=4");
            die();
        }
    }


    $sql ="INSERT INTO `category`(`id`, `name`,`image`) VALUES (null,'$category','$image_name')";
    if ($result=$connection->query($sql)){
    
		header("location:../../add_main_category_form.php?msg=1");
	}else{
        header("location:../../add_main_category_form.php?msg=2");
    }
}else{
        header("location:../../add_main_category_form.php?msg=3");
    }




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>