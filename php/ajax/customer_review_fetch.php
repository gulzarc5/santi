<?php
include "../admin_login_system/php_user_session_check.php";
include "../database/connection.php";
header("content-type: application/json");
$request = $_REQUEST;


$sql_count = "SELECT `users`.`name`,`customer_review`.`user_id`,`customer_review`.`star`,`customer_review`.`comments`,`customer_review`.`status`,`customer_review`.`create_at` FROM `customer_review` INNER JOIN `users` ON `users`.`id`=`customer_review`.`user_id`";

//Searching 
if (!empty($request['search']['value'])) {
	$srch_key = $request['search']['value'];
	$sql_count = $sql_count." WHERE `users`.`name` LIKE '%$srch_key%' OR `customer_review`  LIKE '%$srch_key%' OR `customer_review`.`star` LIKE '%$srch_key%' OR `customer_review`.`user_id` LIKE '%$srch_key%'";

}

//End Searching
if ($res_count = $connection->query($sql_count)) {
	$totalData = $res_count->num_rows;
	$totalFilater = $res_count->num_rows;
}


$sql = "SELECT `customer_review`.`id` AS r_id, `users`.`name` AS u_name,`customer_review`.`user_id` AS u_id,`customer_review`.`star` AS star,`customer_review`.`comments` AS comment,`customer_review`.`status` AS status,`customer_review`.`create_at` AS created_at FROM `customer_review` INNER JOIN `users` ON `users`.`id`=`customer_review`.`user_id`";

//Searching 
if (!empty($request['search']['value'])) {
	$srch_key = $request['search']['value'];
	$sql = $sql_count." WHERE `users`.`name` LIKE '%$srch_key%' OR `customer_review`  LIKE '%$srch_key%' OR `customer_review`.`star` LIKE '%$srch_key%' OR `customer_review`.`user_id` LIKE '%$srch_key%'";

}
	//Ordering
	// if($request['order'][0]['column'] != 0){
	// 	$str_ord = $request['order'][0]['column'];
	// 	$en_ord = $request['order'][0]['dir'];
	// 	$sql = $sql."ORDER BY $str_ord $en_ord ";
	// }else{
	// 	$sql = $sql."ORDER BY `id` DESC ";
	// }
	$sql = $sql."LIMIT $request[start],$request[length]";


	if ($res = $connection->query($sql)) {
		$data = [];
		$count = 1;
		while ($row_user = $res->fetch_assoc()) {
			$status = 1;
			$action = '<a href="php/review/review_delete.php?r_id='.$row_user['r_id'].'" class="btn btn-danger">Delete</a>';
             if ($row_user['status'] == 1) {
             	$action = $action.'<a href=php/review/review_status.php?r_id='.$row_user['r_id'].'&status=2" class="btn btn-success">Approve</a>';
             	$status = "<p class='btn btn-warning disabled'>UnApproved</p>";
             }elseif ($row_user['status'] == 2) {
             	$action = $action.'<a href="php/review/review_status.php?r_id='.$row_user['r_id'].'&status=1" class="btn btn-danger">reject</a>';
             	$status = "<p class='btn btn-warning success'>Approved</p>";;
             }


			$data[] = [
				$count,
				$row_user['u_id'],
				$row_user['u_name'],
				$row_user['comment'],
				$status,
				$action,
			];
			$count++;
		}

		$jsonData = array(
			"draw" => intval(isset($_REQUEST["draw"]) ? $_REQUEST["draw"] : 0),
			"recordsTotal" => intval($totalData),
			"recordsFiltered" => intval($totalFilater),
			"data" => $data
		);

		echo json_encode($jsonData);
	}

?>