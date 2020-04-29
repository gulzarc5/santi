<?php
	include_once '../../php/database/connection.php';
	// include_once '../security/api_key_check.php';
 	header("content-type: application/json");

 	if (!empty($_POST['cat_id']) && !empty($_POST['page_no'])){
 		$page = $connection->real_escape_string(mysql_entities_fix_string($_POST['page_no']));

 		// Type = 1 Means Fetch Product By Category
 		// Type = 2 Means Fetch Product By Sub Category
 		$type = $connection->real_escape_string(mysql_entities_fix_string($_POST['type']));
 		$cat_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['cat_id']));

 		if ($type == 2) {
 			$sql_count = "SELECT * FROM `product` WHERE `sub_cat_id`='$cat_id' AND `is_delete`='1'";
 		}else{
 			$sql_count = "SELECT * FROM `product` WHERE `category_id`='$cat_id' AND `is_delete`='1'";
 		}
 		

 		if ($res = $connection->query($sql_count)) {
			$total_rows = $res->num_rows;
			$total_page = ceil($total_rows/10);

			$limit = ($page*10)-10;

			if ($type == 2) {
	 			$sql= "SELECT * FROM `product` WHERE `sub_cat_id`='$cat_id' AND `is_delete`='1' ORDER BY `id` DESC LIMIT $limit,10";
	 		}else{
	 			$sql= "SELECT * FROM `product` WHERE `category_id`='$cat_id' AND `is_delete`='1' ORDER BY `id` DESC LIMIT $limit,10";
	 		}
			
			if ($res = $connection->query($sql)) {
				if ($res->num_rows > 0) {
					while ($row = $res->fetch_assoc()) {
						$data[] = [
							'id' => $row['id'],
							'name' => $row['name'],
							'mrp' => $row['mrp'],
							'price' => $row['price'],
							'cash_back' => $row['cash_back'],
							'promotional_bonus' => $row['promotional_bonus'],
							'is_star_product' => $row['is_star_product'],
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
						'total_page' => null,
						'data' => $data,
						];
						http_response_code(200);
						echo json_encode($response);
						die();
				}
				

			}else{
				$data = [];
	 			$response =[
					"status" => false,
					'message' => 'Something Went Wrong',
					'code' => 200,
					'total_page' => null,
					'data' => $data,
					];
					http_response_code(200);
					echo json_encode($response);
					die();
			}
		}else{
			$data = [];
 			$response =[
				"status" => false,
				'message' => 'Something Went Wrong',
				'total_page' => null,
				'data' => $data,
				];
				http_response_code(200);
				echo json_encode($response);
				die();
		}

 	}else{
 		$data = [];
 		$response =[
				"status" => false,
				'message' => 'Please Check Required Fields',
				'total_page' => null,
				'data' => $data,
				];
				http_response_code(200);
				echo json_encode($response);
				die();
 	}


function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
	if (get_magic_quotes_gpc()) 
	    $string = stripslashes($string);
	    return $string;
}
 ?>