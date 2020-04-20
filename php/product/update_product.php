<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";



if(isset($_POST['update_product']) && !empty($_POST['p_id'])){
    $p_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['p_id']));
    $name = $connection->real_escape_string(mysql_entities_fix_string($_POST['name']));
    $category = $connection->real_escape_string(mysql_entities_fix_string($_POST['category']));
    $sub_category = $connection->real_escape_string(mysql_entities_fix_string($_POST['sub_category']));
    $description = $connection->real_escape_string(mysql_entities_fix_string($_POST['description']));
    $mrp = $connection->real_escape_string(mysql_entities_fix_string($_POST['mrp']));
    $price = $connection->real_escape_string(mysql_entities_fix_string($_POST['price']));
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
   

   $sql_p_check = "SELECT * FROM `product` WHERE `name`='$name' AND `sub_cat_id`='$sub_category' AND `is_delete` = '1'";
   if ($res_p_check = $connection->query($sql_p_check)) {
       if ($res_p_check->num_rows > 0) {
            $product_row = $res_p_check->fetch_assoc();
            if ($product_row['id'] != $p_id ) {
                header("location:../../product_edit.php?p_id=".$p_id."&msg=5");
            die();
            }
            
       }
   }
    $image = $_FILES['image'];
    $image_name = null;
        if (!empty($image['name'])) {
              $image_size = $image['size'];
                if ($image_size > 2097152 || $image_size < 2 ) {
                        header("location:../../product_edit.php?p_id=".$p_id."&msg=6");
                        die();
                }



            $product_image_name   = $image['name'];
            $product_image_tmp_name = $image['tmp_name'];
            $ext_explode = explode(".",$product_image_name);
            $ext = strtolower(end($ext_explode));
            if( $ext=='jpg' || $ext=='jpeg' || $ext=='png' || $ext=='bmp' || $ext=='gif' ){
                $image_name = md5(uniqid()).date('now').".".$ext;
                $path = "../../uploads/product_image/".$image_name ;
                $image_api_image_url ="uploads/product_image/".$image_name ;
                move_uploaded_file($product_image_tmp_name,$path);

                include_once("ak_php_img_lib_1.0.php");
                $thumb_path = "../../uploads/product_image/thumb/".$image_name;
                $wmax = 250;
                $hmax = 200;
                ak_img_resize($path,$thumb_path, $wmax, $hmax, $ext);

            }else{
                header("location:../../product_edit.php?p_id=".$p_id."&msg=4");
                die();
            }
        }
        // Image Check section end
        // Update Product 

        $sql_update_product = "UPDATE `product` SET `name`='$name',`mrp`='$mrp',`category_id`='$category',`sub_cat_id`='$sub_category',`description`='$description',`hsn_code` = '$hsn_code',`cost`='$cost',`cash_back` = '$cash_back',`promotional_bonus` = '$promotional_bonus', `cgst` = '$cgst',`cgst_percent` = '$cgst_percent',`sgst` = '$sgst',`sgst_percent` = '$sgst_percent',`price`='$price', `stock`='$stock', `expiry_date` = '$expiry_date' WHERE `id`='$p_id'";
        // echo $sql_update_product;
        // die();
        if ($res_update_product = $connection->query($sql_update_product)) {
            
            //If product updated And have Image Update Image
            if (!empty($image_name)) {
                $sql_fetch_product_image ="SELECT `image` FROM `product` WHERE `id`='$p_id'";
                if ($res_fetch_product_image = $connection->query($sql_fetch_product_image)) {
                    $fetch_product_image_row = $res_fetch_product_image->fetch_assoc();
                    $unlink_path = "../../uploads/product_image/".$fetch_product_image_row['image'];
                    unlink($unlink_path);
                    $unlink_thumb_path = "../../uploads/product_image/thumb/".$fetch_product_image_row['image'];
                    unlink($unlink_thumb_path);

                }

                $sql_image = "UPDATE `product` SET  `image` = '$image_name' where `id`='$p_id' ";
                $res_image = $connection->query($sql_image);
            }
            header("location:../../product_edit.php?p_id=".$p_id."&msg=1");
            //Image Update End
        }else{
            header("location:../../product_edit.php?p_id=".$p_id."&msg=3");
        }
    }else{
    header("location:../../product_edit.php?p_id=".$p_id."&msg=4");
        die();
}



function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
    if (get_magic_quotes_gpc()) 
        $string = stripslashes($string);
    return $string;
}
?>