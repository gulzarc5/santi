<?php
	include_once '../../php/database/connection.php';
	// include_once '../security/device_id_check';
 	header("content-type: application/json");
	$sql = "SELECT * FROM `slider` WHERE `status`='1'";
	if ($res = $connection->query($sql)) {

		if ($res->num_rows < 1) {
			$sliders=[];
			$response =[
			"status" => true,
			'message' => 'ok',
			'code' => 200,
			'data' =>$sliders,
			];
			http_response_code(200);
			echo json_encode($response);
			die();
		}else{
			while($slider = $res->fetch_assoc()){		
			$sliders[] = [
			'id' => $slider['id'],
			'image' => $slider['image'],
			];
			}
			$response =[
			"status" => true,
			'message' => 'ok',
			'code' => 200,
			'data' =>$sliders,
			];
			http_response_code(200);
			echo json_encode($response);
		}		 
		
	}else{
		$sliders=[];
		$response =[
			"status" => true,
			'message' => 'Something Wrong',
			'code' => 200,
			'data' =>$sliders,
		];
		http_response_code(200);
		echo json_encode($response);
	}
	
?>