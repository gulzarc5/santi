<?php
// include "../admin_login_system/php_user_session_check.php";
include "../../database/connection.php";
header("content-type: application/json");

if (isset($_POST['search_key']) && !empty($_POST['search_key'])) {
	$search_key = $_POST['search_key'];
	$sql = "SELECT `product`.*,`category`.`name` as c_name FROM `product` LEFT JOIN `category` ON `category`.`id` = `product`.`category_id` WHERE `product`.`barcode` = '$search_key'";

	if ($res_sql = $connection->query($sql)) {
		if ($res_sql->num_rows > 0) {
			$row = $res_sql->fetch_assoc();
			$html = ' <div class="ln_solid"></div>
			<div class="col-md-6"> 
              <h4>Product Info</h4>  
                <div class="col-md-12">       
                  <b>Name : </b> '.$row['name'].' 
                </div>
                <div class="col-md-12">     
                  <b>Category : </b> '.$row['c_name'].'
                </div> 
                <div class="col-md-12">                
                  <b>Available Stock : </b> '.$row['stock'].'
                </div>
              </div>
              <div class="col-md-6">     
                <img src="uploads/product_image/thumb/'.$row['image'].'" "="" alt="..." style="width: 129px;">
              </div>';
			echo json_encode($html);
		}else{
			echo "3";
		}
	}else{
		echo "2";
	}
}else{
	echo "2";
}



?>