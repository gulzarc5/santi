<?php
	include_once '../../php/database/connection.php';
	// include_once '../security/device_id_check';
	header("content-type: application/json");
	
	$sliders = [];
	$new_arrivals = [];
	$star_products = [];

	$sql = "SELECT * FROM `slider` WHERE `status`='1'";
	if ($res = $connection->query($sql)) {
		while($slider = $res->fetch_assoc()){		
			$sliders[] = [
			'id' => $slider['id'],
			'image' => $slider['image'],
			'title' => $slider['title'],
			];
		}
	}

	$sql = "SELECT * FROM `product` ORDER BY `id` DESC LIMIT 10";
	if ($res = $connection->query($sql)) {
		while($new_arrival = $res->fetch_assoc()){		
			$new_arrivals[] = [
			'id' => $new_arrival['id'],
			'name' => $new_arrival['name'],
			'mrp' => $new_arrival['mrp'],
			'price' => $new_arrival['price'],
			'cash_back' => $new_arrival['cash_back'],
			'promotional_bonus' => $new_arrival['promotional_bonus'],
			'is_star_product' => $new_arrival['is_star_product'],
			'image' => $new_arrival['image'],
			];
		}
	}

	$sql = "SELECT * FROM `product` WHERE `is_star_product`='2' ORDER BY `id` DESC";
	if ($res = $connection->query($sql)) {
		while($star_product = $res->fetch_assoc()){		
			$star_products[] = [
			'id' => $star_product['id'],
			'name' => $star_product['name'],
			'mrp' => $star_product['mrp'],
			'price' => $star_product['price'],
			'cash_back' => $star_product['cash_back'],
			'promotional_bonus' => $star_product['promotional_bonus'],
			'is_star_product' => $star_product['is_star_product'],
			'image' => $star_product['image'],
			];
		}
	}

	$data = [
		'sliders' => $sliders,
		'new_arrivals' => $new_arrivals,
		'star_products' => $star_products,
	];
	$response =[
		"status" => true,
		'message' => 'App Load Data',
		'data' =>$data,
	];
	http_response_code(200);
	echo json_encode($response);
	
?>