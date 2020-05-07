<?php
	include_once '../../php/database/connection.php';
 	header("content-type: application/json");

 	if (!empty($_POST['product_id'])) {

 		$product_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['product_id']));
 		$sql = "SELECT * FROM `product` WHERE `id`='$product_id'";
 		if ($res = $connection->query($sql)) {
 			if ($res->num_rows > 0) {
				$row = $res->fetch_assoc();

				$sql_related = "SELECT * FROM `product` WHERE `category_id`='$row[category_id]' AND `id` != '$product_id' ORDER BY `id` DESC LIMIT 10";
				if (!empty($row['sub_cat_id'])) {
					$sql_related = "SELECT * FROM `product` WHERE `sub_cat_id`='$row[sub_cat_id]' AND `id` != '$product_id' ORDER BY `id` DESC LIMIT 10";
				}
				$row['related_products'] = [];
				if ($res_related = $connection->query($sql_related)) {
					$row['related_products'] = $res_related->fetch_all(MYSQLI_ASSOC);
				}
				
	 			$response =[
					"status" => true,
					'message' => 'Product Details',
					'data' => $row,
					];
					http_response_code(200);
					echo json_encode($response);
					die();
 			}else{
 				$data = [];
	 			$response =[
					"status" => true,
					'message' => 'Product Not Found',
					'code' => 200,
					'data' => $data,
					];
					http_response_code(200);
					echo json_encode($response);
					die();
 			}
 			# code...
 		}else{
 			$data = [];
	 		$response =[
					"status" => false,
					'message' => 'Something Went Wrong',
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