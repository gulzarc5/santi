<?php

include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";
date_default_timezone_set('Asia/Kolkata');

if (isset($_POST['package_add'])) {
	$name = $connection->real_escape_string(mysql_entities_fix_string($_POST['name']));
	$description = $connection->real_escape_string(mysql_entities_fix_string($_POST['description']));
	$start_offer = $connection->real_escape_string(mysql_entities_fix_string($_POST['start_offer']));
	$end_offer = $connection->real_escape_string(mysql_entities_fix_string($_POST['end_offer']));



	$image = $_FILES['image'];

	$image_name = null;
    if (!empty($image['name'])) {

        $image_size = $image['size'];
        if ($image_size > 2097152 || $image_size < 2 ) {
                header("location:../../offer_form.php?msg=3");
                die();
        }

        $product_image_name   = $image['name'];
        $product_image_tmp_name = $image['tmp_name'];
        $ext_explode = explode(".",$product_image_name);
        $ext = strtolower(end($ext_explode));
        if( $ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='bmp' || $ext=='gif' ){
            $image_name = md5(uniqid()).date('Y-m-d').".".$ext;
            $path = "../../uploads/package_image/".$image_name ;
            move_uploaded_file($product_image_tmp_name,$path);

            include_once("ak_php_img_lib_1.0.php");
            $thumb_path = "../../uploads/package_image/thumb/".$image_name;
            $wmax = 250;
            $hmax = 200;
            ak_img_resize($path,$thumb_path, $wmax, $hmax, $ext);

        }else{
            header("location:../../offer_form.php?msg=4");
            die();
        }
    }


    $date = date('Y-m-d H:i:s');
	$sql = "INSERT INTO `offer`(`id`, `name`, `description`, `image`, `offer_type`, `offer_start`, `offer_end`, `percentage`, `status`, `date`) VALUES (null,'$name','$description','$image_name','1','$start_offer','$end_offer',null,'1','$date')";
	if ($res = $connection->query($sql)) {
		header("location:../../offer_form.php?msg=1");
         die();
	}else{
		 header("location:../../offer_form.php?msg=2");
         die();
	}
}else{
	 header("location:../../offer_form.php?msg=2");
     die();
}




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>