<?php
	include_once '../../php/database/connection.php';
 	header("content-type: application/json");

 		if (!empty($_POST['search_key']) && !empty($_POST['page_no'])) {
 		    
 		    
 		$page = $connection->real_escape_string(mysql_entities_fix_string($_POST['page_no']));
 		$search_key = $connection->real_escape_string(mysql_entities_fix_string($_POST['search_key']));
 		$key_search = explode(" ", $search_key);
//  		print_r($key_search);
//  		die();
 		$sql_count = "SELECT COUNT(*) as total_rows FROM `product` WHERE `category_id`!='1009' AND `is_delete`='1'";
 		foreach($key_search as $search){
 		    if(!empty($search)){
 		        $sql_count =$sql_count." AND (`name` LIKE '%$search%')";
 		    }
 		   	
 		}
 	
 		if ($res = $connection->query($sql_count)) {
			$total_row = $res->fetch_assoc();
			$total_rows = $total_row['total_rows'];
			//print_r($total_row);
			$total_page = ceil($total_rows/10);

			$limit = ($page*10)-10;
			$sql_product = "SELECT * FROM `product` WHERE `category_id`!='1009' AND `is_delete`='1'";
			foreach($key_search as $search){
			    if(!empty($search)){
			        $sql_product =$sql_product." AND (`name` LIKE '%$search%')";
			    }
 		   	    
 		    }
 		    $sql_product =$sql_product." ORDER BY `id` DESC LIMIT $limit,10";
 		 //   echo $sql_product;
 		 //   die();
			if ($res_product = $connection->query($sql_product)) {
				if ($res_product->num_rows > 0) {
					while ( $row_product = $res_product->fetch_assoc() ) {						
						$data[] = [
							'id' => $row_product['id'],
							'name' => $row_product['name'],
							'mrp' => $row_product['mrp'],
							'price' => $row_product['price'],
							'cash_back' => $row_product['cash_back'],
							'promotional_bonus' => $row_product['promotional_bonus'],
							'is_star_product' => $row_product['is_star_product'],
							'image' => $row_product['image'],
						];

					}
					$response =[
						"status" => true,
						'message' => 'Product List',
						'total_page' => $total_page,
						'search_key' => $search_key,
						'data' =>$data,
						
					];
					http_response_code(200);
					echo json_encode($response,JSON_NUMERIC_CHECK);
				}else{
					$product = [];
					$response =[
						"status" => false,
						'message' => 'Product Not Found',
						'total_page' => $total_page,
						'search_key' => $search_key,
						'data' =>$product,
					];
					http_response_code(200);
					echo json_encode($response,JSON_NUMERIC_CHECK);
				}
			}else{
				$product = [];
				$response =[
					"status" => false,
					'message' => 'Something Went Wrong',
					'total_page' => 0,
					'search_key' => $search_key,
					'data' =>$product,

				];
				http_response_code(200);
				echo json_encode($response,JSON_NUMERIC_CHECK);
			}

		}else{
			$product = [];
				$response =[
					"status" => false,
					'message' => 'Something Went Wrong',
					'total_page' => 0,
					'search_key' => $search_key,
					'data' =>$product,
				];
				http_response_code(200);
				echo json_encode($response,JSON_NUMERIC_CHECK);
		}
 		
 	}else{
 		$product = [];
				$response =[
					"status" => false,
					'message' => 'Search_key And Page No. Can Not Be Empty',
					'total_page' => 0,
					'data' =>$product,
				];
				http_response_code(200);
				echo json_encode($response,JSON_NUMERIC_CHECK);
 	}

function mysql_entities_fix_string($string){return htmlentities(mysql_fix_string($string));}
function mysql_fix_string($string){
	if (get_magic_quotes_gpc()) 
	    $string = stripslashes($string);
	    return $string;
}
?>