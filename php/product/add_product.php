<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";
date_default_timezone_set('Asia/Kolkata');

if(isset($_POST['add_product']) && !empty($_POST['add_product'])){
    $bar_code = $connection->real_escape_string(mysql_entities_fix_string($_POST['bar_code']));

	$name = $connection->real_escape_string(mysql_entities_fix_string($_POST['name']));
    $category = $connection->real_escape_string(mysql_entities_fix_string($_POST['category']));
    $sub_category = $connection->real_escape_string(mysql_entities_fix_string($_POST['sub_category']));
    $description = $connection->real_escape_string(mysql_entities_fix_string($_POST['description']));
    $price = $connection->real_escape_string(mysql_entities_fix_string($_POST['price']));
    $mrp = $connection->real_escape_string(mysql_entities_fix_string($_POST['mrp']));
    $stock = $connection->real_escape_string(mysql_entities_fix_string($_POST['stock']));
    $category = $connection->real_escape_string(mysql_entities_fix_string($_POST['category']));

    $hsn_code = $connection->real_escape_string(mysql_entities_fix_string($_POST['hsn_code']));
    $cost = $connection->real_escape_string(mysql_entities_fix_string($_POST['cost']));
    $cgst = $connection->real_escape_string(mysql_entities_fix_string($_POST['cgst']));
    $cgst_percent = $connection->real_escape_string(mysql_entities_fix_string($_POST['cgst_percent']));
    $sgst = $connection->real_escape_string(mysql_entities_fix_string($_POST['sgst']));
    $sgst_percent = $connection->real_escape_string(mysql_entities_fix_string($_POST['sgst_percent']));
    $cash_back = $connection->real_escape_string(mysql_entities_fix_string($_POST['cash_back']));
    $promotional_bonus = $connection->real_escape_string(mysql_entities_fix_string($_POST['promotional_bonus']));
    $expiry_date = $connection->real_escape_string(mysql_entities_fix_string($_POST['expiry_date']));
    $is_star = $connection->real_escape_string(mysql_entities_fix_string($_POST['star']));
   
   $sql_p_check = "SELECT * FROM `product` WHERE `name`='$name' AND `sub_cat_id`='$sub_category'";
   if ($res_p_check = $connection->query($sql_p_check)) {
       if ($res_p_check->num_rows > 0) {
            header("location:../../add_product_form.php?msg=5");
            die();
       }
   }

   if (!empty($bar_code)) {
    $sql_p_check_bar_code = "SELECT * FROM `product` WHERE `barcode`='$bar_code'";
       if ($res_p_check_bar_code = $connection->query($sql_p_check_bar_code)) {
           if ($res_p_check_bar_code->num_rows > 0) {
                header("location:../../add_product_form.php?msg=7");
                die();
           }
       }
   }  


    $image = $_FILES['image'];
    $image_name = null;
    if (!empty($image['name'])) {

        $image_size = $image['size'];
        if ($image_size > 2097152 || $image_size < 2 ) {
                header("location:../../add_product_form.php?msg=6");
                die();
        }

        $product_image_name   = $image['name'];
        $product_image_tmp_name = $image['tmp_name'];
        $ext_explode = explode(".",$product_image_name);
        $ext = strtolower(end($ext_explode));
        if( $ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='bmp' || $ext=='gif' ){
            $image_name = md5(uniqid()).date('Y-m-d').".".$ext;
            $path = "../../uploads/product_image/".$image_name ;
            $image_api_image_url ="uploads/product_image/".$image_name ;
            move_uploaded_file($product_image_tmp_name,$path);

            include_once("ak_php_img_lib_1.0.php");
            $thumb_path = "../../uploads/product_image/thumb/".$image_name;
            $wmax = 250;
            $hmax = 200;
            ak_img_resize($path,$thumb_path, $wmax, $hmax, $ext);

        }else{
            header("location:../../add_product_form.php?msg=4");
            die();
        }
    }
    $date = date('Y-m-d');
    $created_at = date("Y-m-d H:i:s");
    if (!empty($sub_category)) {
        $sql ="INSERT INTO `product`(`id`, `barcode`,`name`, `category_id`, `sub_cat_id`, `description`,`hsn_code`,`cost`,`cash_back`,`promotional_bonus`,`cgst`,`cgst_percent`,`sgst`,`sgst_percent`,`mrp`, `price`, `image`,`stock`, `is_delete`, `is_star_product`, `expiry_date`, `star_added_date`, `created_at`) VALUES (null,'$bar_code','$name','$category','$sub_category','$description','$hsn_code','$cost','$cash_back','$promotional_bonus','$cgst','$cgst_percent','$sgst','$sgst_percent','$mrp','$price','$image_name','$stock','1','$is_star','$expiry_date','$date','$created_at')";
    }else{
         $sql ="INSERT INTO `product`(`id`,`barcode`, `name`, `category_id`, `sub_cat_id`, `description`,`hsn_code`,`cost`,`cash_back`,`promotional_bonus`,`cgst`,`cgst_percent`,`sgst`,`sgst_percent`,`mrp`, `price`, `image`,`stock`, `is_delete`,  `is_star_product`, `expiry_date`,  `star_added_date`, `created_at`) VALUES (null,'$bar_code','$name','$category',null,'$description','$hsn_code','$cost','$cash_back','$promotional_bonus','$cgst','$cgst_percent','$sgst','$sgst_percent','$mrp','$price','$image_name','$stock','1','$is_star','$expiry_date','$date','$created_at')";
    }
   
    if ($result=$connection->query($sql)){
        $product_id = $connection->insert_id;
        $numlength = strlen((string)$product_id);
        if (empty($bar_code)) {
           $digits_needed=(12 - $numlength);
            $random_number=mt_rand(0, 9); // set up a blank string
            $count=0;
            while ( $count < $digits_needed ) {
                $random_digit = mt_rand(0, 9);            
                $random_number .= $random_digit;
                $count++;
            }
            $random_number.=$product_id;
            $sql_bar_code = "UPDATE `product` SET  `barcode` = '$random_number' where `id`='$product_id' ";
            $res_bar_code = $connection->query($sql_bar_code);
        }
        header("location:../../add_product_form.php?msg=1");
	}else{
        header("location:../../add_product_form.php?msg=2");
    }
}else{
    header("location:../../add_product_form.php?msg=3");
}




function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>