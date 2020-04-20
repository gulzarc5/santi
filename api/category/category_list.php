<?php
	include_once '../../php/database/connection.php';
	// include_once '../security/device_id_check';
 	header("content-type: application/json");
	$sql = "SELECT * FROM `category`";
	if ($res = $connection->query($sql)) {
		while($categor = $res->fetch_assoc()){
			$sub_category = false;
			$sub_category_sql = "SELECT * FROM `sub_category` WHERE `category_id`='$categor[id]'";
			if ($sub_category_res = $connection->query($sub_category_sql)) {
			    if( $sub_category_res->num_rows > 0){
    				$sub_category = true;
			    }
			}
			$category[] = [
				'id' => $categor['id'],
				'category' => $categor['name'],
				'image' => $categor['image'],
				'sub_category_status' => $sub_category,
			];
		}
		 
		$response =[
			"status" => true,
			'message' => 'ok',
			'data' =>$category,
		];
		http_response_code(200);
		echo json_encode($response);
	}else{
		$response =[
			"status" => false,
			'message' => 'Something Wrong',
			'data' =>[],
		];
		http_response_code(200);
		echo json_encode($response);
	}
	
?>