<?php
	include_once '../../php/database/connection.php';
 	header("content-type: application/json");

 	if (!empty($_POST['product_id'])) {

 		$product_id = $connection->real_escape_string(mysql_entities_fix_string($_POST['product_id']));
 		$sql = "SELECT * FROM `product` WHERE `id`='$product_id'";
 		if ($res = $connection->query($sql)) {
 			if ($res->num_rows > 0) {
 				$row = $res->fetch_assoc();
 				$data = [
 					'id' => $row['id'],
					'name' => $row['name'],
					'description' => $row['description'],
					'mrp' => $row['mrp'],
					'price' => $row['price'],
					'stock' => $row['stock'],
					'image' => $row['image'],
 				];
	 			$response =[
					"status" => true,
					'message' => 'Product Details',
					'code' => 200,
					'data' => $data,
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
					'code' => 200,
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
				'code' => 400,
				'data' => $data,
				];
				http_response_code(400);
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