<?php
	include_once '../../php/database/connection.php';
	include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if ((!empty($_POST['sub_cat_id']) || !empty($_POST['cat_id'])) && !empty($_POST['page_no'])){
 		$page = $connection->real_escape_string(mysql_entities_fix_string($_POST['page_no']));
 		$sub_cat_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['sub_cat_id']));
 		$cat_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['cat_id']));

 		if (!empty($sub_cat_id)) {
 			$sql_count = "SELECT * FROM `product` WHERE `sub_cat_id`='$sub_cat_id'";
 		}else{
 			$sql_count = "SELECT * FROM `product` WHERE `category_id`='$cat_id'";
 		}
 		

 		if ($res = $connection->query($sql_count)) {
			$total_rows = $res->num_rows;
			$total_page = ceil($total_rows/2);

			$limit = ($page*2)-2;

			if (!empty($sub_cat_id)) {
	 			$sql= "SELECT * FROM `product` WHERE `sub_cat_id`='$sub_cat_id' ORDER BY `id` DESC LIMIT $limit,10";
	 		}else{
	 			$sql= "SELECT * FROM `product` WHERE `category_id`='$cat_id' ORDER BY `id` DESC LIMIT $limit,10";
	 		}
			
			if ($res = $connection->query($sql)) {
				if ($res->num_rows > 0) {
					while ($row = $res->fetch_assoc()) {
						$data[] = [
							'id' => $row['id'],
							'name' => $row['name'],
							'description' => $row['description'],
							'price' => $row['price'],
							'stock' => $row['stock'],
							'image' => $row['image'],
						];
					}
					$response =[
						"status" => true,
						'message' => 'Product List Category Wise',
						'code' => 200,
						'total_page' => $total_page,
						'data' => $data,
						];
						http_response_code(200);
						echo json_encode($response);
						die();
				}else{
					$data = [];
		 			$response =[
						"status" => false,
						'message' => 'Product Not Found',
						'code' => 400,
						'total_page' => null,
						'data' => $data,
						];
						http_response_code(400);
						echo json_encode($response);
						die();
				}
				

			}else{
				$data = [];
	 			$response =[
					"status" => false,
					'message' => 'Something Went Wrong',
					'code' => 400,
					'total_page' => null,
					'data' => $data,
					];
					http_response_code(400);
					echo json_encode($response);
					die();
			}
		}else{
			$data = [];
 			$response =[
				"status" => false,
				'message' => 'Something Went Wrong',
				'code' => 400,
				'total_page' => null,
				'data' => $data,
				];
				http_response_code(400);
				echo json_encode($response);
				die();
		}

 	}else{
 		$data = [];
 		$response =[
				"status" => false,
				'message' => 'Please Check Required Fields',
				'code' => 400,
				'total_page' => null,
				'data' => $data,
				];
				http_response_code(400);
				echo json_encode($response);
				die();
 	}

 ?>