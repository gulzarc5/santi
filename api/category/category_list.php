<?php
	include_once '../../php/database/connection.php';
	// include_once '../security/device_id_check';
 	header("content-type: application/json");
	$sql = "SELECT * FROM `category`";
	if ($res = $connection->query($sql)) {
		while($categor = $res->fetch_assoc()){
			$sub_category = null;
			$sub_category_sql = "SELECT * FROM `sub_category` WHERE `category_id`='$categor[id]'";
			if ($sub_category_res = $connection->query($sub_category_sql)) {
			    if( $sub_category_res->num_rows > 0){
    				while ($sub_category_row = $sub_category_res->fetch_assoc()) {
    					$sub_category[] = [
    						'sub_cat_id' => $sub_category_row['id'],
    						'sub_cat_name' => $sub_category_row['name'],
    					];
    				}
			    }else{
			        $sub_category = [];
			    }
			}
			$category[] = [
			'id' => $categor['id'],
			'category' => $categor['name'],
			'subcategory' => $sub_category,
		];
		}
		 
		$response =[
			"status" => true,
			'message' => 'ok',
			'code' => 200,
			'data' =>$category,
		];
		http_response_code(200);
		echo json_encode($response);
	}else{
		$response =[
			"status" => false,
			'message' => 'Something Wrong',
			'code' => 400,
			'data' =>null,
		];
		http_response_code(400);
		echo json_encode($response);
	}
	
?>